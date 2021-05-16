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

                $products[] = $row;
            }
        }
        var_dump(json_encode($products));
        die();
        return json_encode($products);
    }
}
