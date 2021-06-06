<?php


class ShoppingCart
{
    private $shoppingCart = array();

    //checks whether the shopping cart exists in the session or not
    public function checkShoppingCart($shoppingCart){

        if($shoppingCart != ""){
            return true;
        }

        return false;
    }

    //checks whether a product is in the shopping cart
    public function checkProductInShoppingCart($id){

        if(count($this->shoppingCart) == 0){
            return false;
        }

        for($i = 0; $i < count($this->shoppingCart); $i++){
            if(strcmp($this->shoppingCart[$i]->getId(), $id) == 0){
                return true;
            }
        }

        return false;
    }

    //adds a product to the shopping cart
    public function addProduct($item){
        array_push($this->shoppingCart, $item);
    }

    //increase amount of product when the product is in the shopping cart
    public function increaseAmountOfProduct($id){
        for($i = 0; $i < count($this->shoppingCart); $i++){
            if(strcmp($this->shoppingCart[$i]->getId(), $id) == 0){
                $this->shoppingCart[$i]->setAmount($this->shoppingCart[$i]->getAmount()+1);
            }
        }
    }

    //decrease amount of product, when the product is in the shopping cart
    public function decreaseAmountOfProduct($id){
        for($i = 0; $i < count($this->shoppingCart); $i++){
            if(strcmp($this->shoppingCart[$i]->getId(), $id) == 0){
                if($this->shoppingCart[$i]->getAmount() > 1){
                    $this->shoppingCart[$i]->setAmount($this->shoppingCart[$i]->getAmount() - 1);
                }
                else{
                    $this->deleteProduct($id);
                }
            }
        }
    }
    //delete a product from the shopping list
    public function deleteProduct($id){
        $tempShoppingCart = array();
        for($i = 0; $i < count($this->shoppingCart); $i++){
            if(strcmp($this->shoppingCart[$i]->getId(), $id) != 0){
                array_push($tempShoppingCart, $this->shoppingCart[$i]);
            }
        }
        $this->shoppingCart = $tempShoppingCart;
    }

    //This method returns the shopping cart
    public function getShoppingCart(){
        return $this->shoppingCart;
    }

    //This method clears the shoppingcart
    public function clearShoppingCart(){
        $this->shoppingCart = array();
    }


}