<?php
require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";

class SearchController extends AbstractController
{
    function search()
    {
        $searchTerm = $this->request->GET("searchTerm");

        $query = "SELECT * FROM produkte WHERE LOWER(Name) LIKE '%$searchTerm%'";


        $result = $this->database->query($query);
        $products = array();

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                array_push($products,$row);
            }
        }

        echo json_encode($products);
    }
}
