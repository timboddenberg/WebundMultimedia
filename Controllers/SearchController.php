<?php
require_once __DIR__ . "\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";

class SearchController extends AbstractController
{
    function search()
    {
        $searchTerm = $this->request->GET("searchTerm");

        $fileContent = require_once __DIR__ . '\\..\temp\prodCache.php';
        echo json_encode($fileContent);
    }

    public static function setUpProductCache()
    {
        $query = "SELECT * FROM produkte";

        $database = DatabaseEngine::getConnection();
        $result = $database->query($query);

        $fileContent = "<?php
        
        return [";

        $counter = 0;
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $product = new Product($row["Id"],$row["Name"],$row["Preis"],$row["BildURL"],$row["Bestand"]);
                $fileContent = $fileContent . "
                    '$counter' => [
                        'Id' => '" . $product->getId() . "',
                        'Name' => '" . $product->getName() . "',
                        'Preis' => '" . $product->getPrice() . "',
                        'Bestand' => '" . $product->getAmount() . "',
                    ],
                ";

                $counter++;
            }
        }

        $database->close();

        $file = __DIR__ . "\\..\\temp\prodCache.php";

        file_put_contents($file, $fileContent . "];");
    }
}
