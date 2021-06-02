<?php

require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";
require_once __DIR__ . "\..\Models\Comment.php";
require_once __DIR__ . "\..\Models\CommentFactory.php";
require_once __DIR__ . "\..\Models\User.php";
require_once __DIR__ . "\..\Models\Rating.php";

class ProductController extends AbstractController{

    public function displayProduct()
    {
        $productId = $this->request->SESSION("productId");
        $commentFactory = new CommentFactory($productId);

        if (! empty($productId))
        {
            $product = $this->getProductFromDatabase($productId);
            $this->assignProductVariables($product);
            $this->templateEngine->addVariable("avgRating", $commentFactory->getAverageRating($productId));
            $this->templateEngine->addVariable("comments", $commentFactory->generateHtmlProductComments());
            $this->templateEngine->display("/Product/Product.tpl");
        }
    }

    private function assignProductVariables(array $product)
    {
        foreach ($product as $key => $value)
        {
            $this->templateEngine->addVariable($key, $value);
        }
    }

    private function getProductFromDatabase(string $id)
    {
        $result = $this->database->query("SELECT * FROM produkte WHERE Id = " . $id);

        $product = $result->fetch_assoc();

        if ($product == NULL)
        {
            $this->errorHandler->setErrorMessage("Es wurde kein Produkt zu der ID gefunden.");
            header("Location: http://Localhost/WebundMultimedia/");
            die;
        }

        return $product;
    }

    public function displayAddComment()
    {
        User::validateUserRequest($this->user);

        $productId = $this->request->SESSION("productId");
        $this->assignProductVariables($this->getProductFromDatabase($productId));
        $this->templateEngine->display("\product\AddComment.tpl");
    }

    public function displayProductAdministration()
    {
        User::validateAdminRequest($this->user);

        $this->templateEngine->addVariable("productList",$this->generateHtmlProduct());
        $this->templateEngine->display("/Product/ProductAdministration.tpl");
    }

    public function addProduct()
    {
        User::validateAdminRequest($this->user);

        $name = $this->request->POST("name");
        $image = $this->generateBase64String($this->request->FILE("image"));
        $amount = $this->request->POST("amount");
        $price = $this->request->POST("price");
        $description = $this->request->POST("description");
        $brand = $this->request->POST("brand");
        $color = $this->request->POST("color");
        $material = $this->request->POST("material");

        $query = "INSERT INTO produkte VALUES('','$name', '$price', '$amount','$description','$image','$brand','$color','$material')";
        $this->database->query($query);
        header("Location: http://Localhost/WebundMultimedia/product/administration");
        die;
    }

    private function generateBase64String($image)
    {
        return 'data:' . $image["type"] . ';base64, ' . base64_encode(file_get_contents($image["tmp_name"]));
    }

    public function deleteProduct()
    {
        User::validateAdminRequest($this->user);

        $id = $this->request->GET("productID");
        $query = "DELETE FROM produkte WHERE id = '" . $id . "'";
        $this->database->query($query);
        header("Location: http://Localhost/WebundMultimedia/product/administration");
        die;
    }

    private function getAllProducts()
    {
        $query = "SELECT * FROM produkte ";
        $result = $this->database->query($query);
        $products = array();

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $products[] = new Product($row["Id"],$row["Name"],$row["Preis"],$row["BildURL"],$row["Bestand"], $row["Beschreibung"], $row["Marke"], $row["Farbe"], $row["Material"]);
            }
        }
        return $products;
    }

    private function generateHtmlProduct()
    {
        $products = $this->getAllProducts();
        $html = "";

        foreach ($products as $product)
        {
            $tempHtml =
                '
                    <div class="row productListWrapper">
                        <div class="productImageList col-md-2">
                            <img src="' . $product->getImage() . '"/>
                        </div>
                        <div class="productNameList col-md-4">
                            '. $product->getName() .'
                        </div>
                        <div class="productRemoveIcon col-md-3 right">
                            <a href="/WebundMultimedia/product/delete?productID='. $product->getId() .'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="editProductButton col-md-1 right">
                             <a href="/WebundMultimedia/product/edit?productID='.$product->getId().'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-pencil" viewBox="0 0 16 16" >
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                ';

            $html = $html . $tempHtml;
        }

        return $html;
    }

    private function generateHtmlAllProducts()
    {
        $productList = $this->getAllProducts();
        $productsHtml = "";

        foreach ($productList as $product)
        {
            $image = $product->getImage();
            $name = $product->getName();
            $price = $product->getPrice();
            $productId = $product->getId();
            $description = $product->getDescription();
            $amount = $product->getAmount();

            $tempHtml =
                '   
                    <a style="text-decoration:none" href="/WebundMultimedia/product/'.$productId.'">
                        <div class="row singleProductWrapper">                        
                            <div class="col-md-2">
                                <div class="productPictures">
                                    <img src="' . $image . '"/>
                                </div>                                
                            </div>
                            <div class="col-md-2">
                                <div class="productInfoText">
                                    <p>'.$name.'</p>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="productInfoText">
                                    <p>'.$price.'€</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="productInfoDescription">
                                    <p>'.$description.'</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="productInfoText">
                                    <p>Aktueller Bestand:<br>'.$amount.'</p>
                                </div>
                            </div>
                        </div>
                    </a>                                             
                    <hr>                
                ';

            $productsHtml = $productsHtml . $tempHtml;
        }
        return $productsHtml;
    }

    public function displayAllProducts()
    {
            $this->templateEngine->addVariable("allProducts", $this->generateHtmlAllProducts());
            $this->templateEngine->display("/Product/AllProducts.tpl");
    }

    //This method displays the edit product page
    public function displayEditProductInDatabase()
    {
        User::validateAdminRequest($this->user);

        $productId = $this->request->GET("productID");

        if(! empty($productId)){
            $product = $this->getProductFromDatabase($productId);
            $this->assignProductVariables($product);
        }

        $this->templateEngine->display("/Product/EditProduct.tpl");

    }

    //This method edits a product in the database
    public function editProductInDatabase()
    {
        User::validateAdminRequest($this->user);

        //check product from database
        $productID = $this->request->GET("productID");
        $query = "SELECT * FROM produkte WHERE Id = '$productID'";
        $result = $this->database->query($query);

        //assign variables and check if an edit exists
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
               $name = $this->checkWhetherAnEditExits($this->request->POST("name"), $row["Name"]);
               $amount = $this->checkWhetherAnEditExits($this->request->POST("amount"), $row["Bestand"]);
               $description = $this->checkWhetherAnEditExits($this->request->POST("description"), $row["Beschreibung"]);
               $price = $this->checkWhetherAnEditExits($this->request->POST("price"), $row["Preis"]);
               $brand = $this->checkWhetherAnEditExits($this->request->POST("brand"), $row["Marke"]);
               $color = $this->checkWhetherAnEditExits($this->request->POST("color"), $row["Farbe"]);
               $material = $this->checkWhetherAnEditExits($this->request->POST("material"), $row["Material"]);
            }
        }

        //edit the product
        $query = "UPDATE produkte SET Name='$name', Preis='$price', Farbe='$color', Bestand='$amount', Beschreibung='$description', Marke='$brand', Material='$material' WHERE Id='$productID'";
        $this->database->query($query);
        header("Location: http://Localhost/WebundMultimedia/product/edit?productID=$productID");
        die();
    }

    public function rateProduct()
    {
        $productId = $this->request->SESSION("productId");
        $commentFactory = new CommentFactory($productId);

        $commentFactory->rateProduct();
    }

    public function addComment()
    {
        $productId = $this->request->SESSION("productId");
        $commentFactory = new CommentFactory($productId);

        $commentFactory->addComment();
    }

    //This method checks whether there is an edit for a product
    private function checkWhetherAnEditExits($newValue, $previousValue){
        if($newValue != ""){
            return $newValue;
        }
        else{
            return $previousValue;
        }
    }

}
