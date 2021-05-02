<?php

session_start();
require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";

class ProductController extends AbstractController{

    public function displayProductAdministration()
    {
        $this->templateEngine->display("/Product/ProductAdministration.tpl");
    }

    public function addProduct(){
        $id = $this->request->POST("id");
        $name = $this->request->POST("name");
        $image =$this->request->POST("image");
        $amount = $this->request->POST("amount");
        $price = $this->request->POST("price");

        $query = "INSERT INTO produkte VALUES('$id','$name', '$price', '$amount','','$image','','','')";
        $this->database->query($query);
        $this->templateEngine->display("/Product/ProductAdministration.tpl");

    }

    public function deleteProduct(){
        $id = $this->request->POST("id");
        $query = "DELETE FROM produkte WHERE id = $id";
        $this->database->query($query);
        $this->templateEngine->display("/Product/ProductAdministration.tpl");
    }

    public function getAllProducts(){
        $query = "SELECT * FROM produkte ";
        $result = $this->database->query($query);
        if($result->num_rows > 0){
            $products = array();
            while($row = $result->fetch_assoc()){
                $product = new Product($row["Name"],$row["Preis"],$row["BildURL"],$row["Bestand"]);
                $products[] = $product;
            }
            return $products;
        }
    }
}
