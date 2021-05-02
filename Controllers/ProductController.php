<?php

session_start();
require_once __DIR__ . "\AbstractController.php";

class ProductController extends AbstractController{

    public function displayAddProduct()
    {
        $this->templateEngine->display("/Product/AddProduct.tpl");
    }

    public function addProduct(){
        $id = $this->request->POST("id");
        $name = $this->request->POST("name");
        $image =$this->request->POST("image");
        $amount = $this->request->POST("amount");
        $price = $this->request->POST("price");

        var_dump($price);die;
        $query = "INSERT INTO produkte VALUES('$id','$name', '$price', '$amount','','$image','','','','')";
        $this->database->query($query);
    }

    public function deleteProduct(){
        $id = $this->request->POST("id");
        $query = "DELETE FROM produkte WHERE id = $id";
        $this->database->query($query);
    }

}