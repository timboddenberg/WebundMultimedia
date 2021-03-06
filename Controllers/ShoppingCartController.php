<?php
require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";
require_once __DIR__ . "\..\Models\ShoppingCartItem.php";
require_once __DIR__ . "\..\Models\ShoppingCart.php";

/*
 * This class does all the backend actions for the shopping cart
 */
class ShoppingCartController extends AbstractController
{
    protected ShoppingCart $shoppingCart;

    public function __construct()
    {
        $this->shoppingCart = new ShoppingCart();
        parent::__construct();
        //set shopping cart from session, if it is not existing, we create the shopping cart in the session
        if(!$this->shoppingCart->checkShoppingCart($this->request->SESSION("shoppingCart"))){
            $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
        }
        else{
            $this->shoppingCart = unserialize($this->request->SESSION("shoppingCart"));
        }
    }

    //This method displays the shopping cart
    public function displayShoppingCart(){
        $this->generateShoppingCartHTML();
        $this->templateEngine->display("/Product/ShoppingCart.tpl");

    }


    //This method adds a product to the shopping cart
    public function addProductToShoppingCart(){

        $id = $this->request->GET('id');

        if($this->shoppingCart->checkProductInShoppingCart($id)){
            $this->shoppingCart->increaseAmountOfProduct($id);
        }
        else{
            $query = "SELECT * FROM produkte WHERE Id  = '" . $id . "'";
            $result = $this->database->query($query);
            $shoppingCartItem = new ShoppingCartItem();
            //set item values
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $shoppingCartItem->setId($row["Id"]);
                    $shoppingCartItem->setName($row["Name"]);
                    $shoppingCartItem->setAmount(1);
                    $shoppingCartItem->setPicture($row["BildURL"]);
                }
                $this->shoppingCart->addProduct($shoppingCartItem);
            }
        }

        $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));

        header("Location: http://Localhost/WebundMultimedia/product/$id");
        die();

    }

    //This method deletes a product from the shopping cart
    public function deleteProductFromShoppingCart(){
        $id = $this->request->GET('id');
        $delete = $this->request->GET('delete');

        if($this->shoppingCart != ""){
            if($this->shoppingCart->checkProductInShoppingCart($id) && $delete == "n"){
                $this->shoppingCart->decreaseAmountOfProduct($id);
                $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
            }
            elseif ($this->shoppingCart->checkProductInShoppingCart($id) && $delete == "y"){
                $this->shoppingCart->deleteProduct($id);
                $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
            }
        }

        header("Location: http://Localhost/WebundMultimedia/shoppingcart");
        die();
    }


    //This method empties the shopping cart
    public function emptyShoppingCart(){
        $this->request->setSESSION("shoppingCart", "");
        header("Location: http://Localhost/WebundMultimedia/shoppingcart");
        die();
    }

    //This method generates the html for the shopping cart
    public function generateShoppingCartHTML(){
        $cart = $this->shoppingCart->getShoppingCart();
        $shoppingCartHTML = "";

        if(count($cart) > 0){
            foreach($cart as $item){
                $tempHTML = '
                <div class="row col-md-12 shoppingCartItem">
                    <div class="productPictures col-md-3">
                        <img src="'. $item->getPicture() .'">
                    </div>
                    <div class="col-md-3 productInfoText">
                        <p>'. $item->getName().'</p>
                    </div>
                    <div class="col-md-3 productInfoText">
                        <p>Menge: '. $item->getAmount().'</p>
                        <a href="http://localhost/WebundMultimedia/shoppingcart/increaseProductInShoppingCart?id='.$item->getId().'" class="increaseButton btn btn-secondary btn-lg active" role="button" aria-pressed="true">+</a>
                        <a href="http://localhost/WebundMultimedia/shoppingcart/decreaseProductInShoppingCart?id='.$item->getId().'" class="decreaseButton btn btn-secondary btn-lg active" role="button" aria-pressed="true">-</a>
                    </div>
                    <div class="col-md-3">
                         <a href="/WebundMultimedia/shoppingcart/deleteproduct?delete=y&id='. $item->getId() .'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#FF2525FF" class="shoppingCartDeleteButton bi bi-trash" viewBox="0 0 16 16">
                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                         </a>
                    </div>
                    
                </div>
                <hr>
            ';
                $shoppingCartHTML = $shoppingCartHTML . $tempHTML;
            }
            $tempHTML = '
            <div>
                <button id="orderButton" type="button"><span>Kaufen</span></button>
            </div>
            ';
            $shoppingCartHTML = $shoppingCartHTML . $tempHTML;
        }
        else{
            $shoppingCartHTML = '
                <div class="emptyShoppingCart">
                    <p>Warenkorb ist leer!</p>
                </div>
                
            ';
        }


        $this->templateEngine->addVariable("shoppingCartHTML", $shoppingCartHTML);

    }

    //This method increases the amount of a product, when the user hits the "+" button in the shopping cart
    public function increaseProductInShoppingCart(){
        $id = $this->request->GET("id");

        if($this->shoppingCart != ""){
            if($this->shoppingCart->checkProductInShoppingCart($id)){
                $this->shoppingCart->increaseAmountOfProduct($id);
                $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
            }
        }
        header("Location: http://Localhost/WebundMultimedia/shoppingcart");
        die();
    }

    //This method decreases the amount of a product, when the user hits the "-" button in the shopping cart
    public function decreaseProductInShoppingCart(){
        $id = $this->request->GET("id");

        if($this->shoppingCart != ""){
            if($this->shoppingCart->checkProductInShoppingCart($id)){
                $this->shoppingCart->decreaseAmountOfProduct($id);
                $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
            }
        }
        header("Location: http://Localhost/WebundMultimedia/shoppingcart");
        die();
    }

    //This method handles the purchase
    public function handlePurchase(){
        User::validateUserRequest($this->user);
        $order = $this->shoppingCart->getShoppingCart();
        foreach ($order as $orderItem){
             $temp = $this->checkInventory($this->shoppingCart, $orderItem);
             $userID = $this->request->SESSION("userID");
             $productID = $orderItem->getId();
             $amount = $orderItem->getAmount();
             $dateTime = date('Y-m-d h:i:s a', time());

             switch($temp){
                 case 0:
                     $this->errorHandler->setErrorMessage("Produkt ist nicht verf??gbar: " . $orderItem->getName());
                     break;
                 case 1:
                     $query = "UPDATE produkte SET Bestand = Bestand - ".$orderItem->getAmount(). " WHERE Id = " . $orderItem->getId();
                     $this->database->query($query);
                     $query = "INSERT INTO bestellungen VALUES ('','$userID', '$productID','$amount','$dateTime')";
                     $this->database->query($query);
                     break;
                 case 2:
                     $this->errorHandler->setErrorMessage("Bestellmenge reduziert von Produkt: " . $orderItem->getName());
                     $query = "UPDATE produkte SET Bestand = Bestand - ".$orderItem->getAmount(). " WHERE Id = " . $orderItem->getId();
                     $this->database->query($query);
                     $query = "INSERT INTO bestellungen VALUES ('','$userID', '$productID','$amount','$dateTime')";
                     $this->database->query($query);
                     break;
             }
        }
        $this->request->setSESSION("orderDone", "y");
        $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
        header("Location: http://Localhost/WebundMultimedia/orderOverview");
        die();
    }

    //This method checks the inventory
    public function checkInventory($order, $orderItem){
        $query = "SELECT * FROM produkte WHERE Id = " . $orderItem->getId();
        $result = $this->database->query($query);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row["Bestand"] == 0){
                    $order->deleteProduct($orderItem->getId());
                    return 0;
                }
                if($orderItem->getAmount() > $row["Bestand"]){
                    $orderItem->setAmount($row["Bestand"]);
                    return 2;
                }
            }
        }
        return 1;
    }

    //This method displays the order overview
    public function displayOrderOverview(){
        $this->generateOrderOverviewHTML();
        $this->shoppingCart->clearShoppingCart();
        $this->request->setSESSION("shoppingCart", serialize($this->shoppingCart));
        $this->request->setSESSION("orderDone", "n");
        $this->templateEngine->display("/Product/OrderOverview.tpl");

    }

    //This method generates the html for the order overview
    private function generateOrderOverviewHTML(){

        $order = $this->shoppingCart->getShoppingCart();
        $orderOverviewHTML = "";

        if($this->request->SESSION("orderDone") == "y" && count($order) > 0){
            $tempHTML = '
            <div class="productAdministrationHeadlineWrapper row">
                <div class="productAdministrationHeadline">
                    <span>Vielen Dank f??r Ihren Einkauf!</span>
                    <br>
                    <br>
                    <span>Bestell??bersicht:</span>
                </div>
            </div>
        ';
            $orderOverviewHTML = $orderOverviewHTML . $tempHTML;
            foreach ($order as $item){
                $tempHTML = '
                    <a href="/WebundMultimedia/product/'.$item->getId().'" style="text-decoration:none">
                        <div class="row col-md-12 shoppingCartItem">
                            <div class="productPictures col-md-4">
                                <img src="'. $item->getPicture() .'">
                            </div>
                            <div class="col-md-4 productInfoText">
                                <p>'. $item->getName().'</p>
                            </div>
                            <div class="col-md-4 productInfoText">
                                <p>Menge: '. $item->getAmount().'</p>
                            </div>               
                    </div>
                    </a>
                    <hr>
            ';
                $orderOverviewHTML = $orderOverviewHTML . $tempHTML;
            }
            $this->templateEngine->addVariable("orderOverviewHTML", $orderOverviewHTML);
        }
        else{
            header("Location: http://Localhost/WebundMultimedia");
            die();
        }
    }








}