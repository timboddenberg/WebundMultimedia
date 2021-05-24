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
    /**
     * ShoppingCartController constructor.
     */
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
}