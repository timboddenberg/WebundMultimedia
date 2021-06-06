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
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" class="bi bi-trash" viewBox="0 0 16 16">
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


}