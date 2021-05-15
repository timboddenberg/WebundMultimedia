<?php

require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";

class ProductController extends AbstractController{

    public function displayProduct()
    {
        $productId = $this->request->SESSION("productId");

        if (! empty($productId))
        {
            $product = $this->getProductFromDatabase($productId);
            $this->assignProductVariables($product);
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

    public function displayProductAdministration()
    {
        $this->templateEngine->addVariable("productList",$this->generateHtmlProduct());
        $this->templateEngine->display("/Product/ProductAdministration.tpl");
    }

    public function addProduct()
    {
        $id = $this->request->POST("id");
        $name = $this->request->POST("name");
        $image = $this->generateBase64String($this->request->FILE("image"));
        $amount = $this->request->POST("amount");
        $price = $this->request->POST("price");

        $query = "INSERT INTO produkte VALUES('$id','$name', '$price', '$amount','','$image','','','')";
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
                $products[] = new Product($row["Id"],$row["Name"],$row["Preis"],$row["BildURL"],$row["Bestand"]);
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
                    </div>
                ';

            $html = $html . $tempHtml;
        }

        return $html;
    }
}
