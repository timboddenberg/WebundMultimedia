<?php

require_once __DIR__ . "\AbstractController.php";

class ActivityController extends AbstractController
{
    // This method displays the activity overview
    public function displayActivityOverview()
    {
        $this->templateEngine->display("Activity/ActivityOverview.tpl");
    }

    // This method echoes the activity data
    public function getActivityData()
    {
        $type = $this->request->GET("type");
        $range = $this->request->GET("range");
        $productId = $this->request->GET("productId");

        switch ($type)
        {
            case "Lagerbestand":
                $amountArray = $this->getOrderedAmountById($productId,$range);
                echo json_encode($amountArray);
                return;
            case "Produkte pro Bestellung":
                $amountArray = $this->getOrderAmounts();
                echo json_encode($amountArray);
                return;
            case "Bestellung pro Tag":
                $amountArray = $this->getOrderAmountsPerDay();
                echo json_encode($amountArray);
                return;
        }
    }

    // This method returns the amount of product m in the last n orders
    private function getOrderedAmountById($productId, $range)
    {
        $query = "SELECT * FROM bestellungen WHERE ProduktId = " . $productId . " LIMIT " . $range;
        $result = $this->database->query($query);
        $orderedAmounts = array();

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                array_push($orderedAmounts, $row["Menge"]);
            }
        }

        return $orderedAmounts;
    }

    // This method echoes all products in the database as option elements
    public function getAllProductFromDatabaseAsOptions()
    {
        $query = "SELECT `Id`,`Name` FROM produkte";
        $result = $this->database->query($query);
        $html = "";

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $html = $html . "<option value='" . $row["Id"] . "'>" . $row["Name"] . "</option>";
            }
        }

        echo $html;
    }

    // This method returns the number of products in the last n orders
    private function getOrderAmounts()
    {
        $limit = $this->request->GET("range");
        $query = "SELECT SUM(bestellungen.Menge) AS amount FROM `bestellungen` GROUP BY BestellId LIMIT " . $limit;
        $result = $this->database->query($query);
        $orderedAmounts = array();

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                array_push($orderedAmounts, $row["amount"]);
            }
        }

        return $orderedAmounts;
    }

    // This method returns the number of orders a day
    private function getOrderAmountsPerDay()
    {
        $limit = $this->request->GET("range");
        $query = "SELECT Sum(bestellungen.Menge) AS amount FROM bestellungen GROUP BY EXTRACT(DAY FROM bestellungen.Datum) ORDER BY bestellungen.Datum ASC LIMIT " . $limit;
        $result = $this->database->query($query);
        $orderedAmounts = array();

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                array_push($orderedAmounts, $row["amount"]);
            }
        }

        return $orderedAmounts;
    }
}