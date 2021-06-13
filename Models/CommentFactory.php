<?php
require_once __DIR__ . "\..\Controllers\AbstractController.php";
require_once __DIR__ . "\..\Models\Product.php";
require_once __DIR__ . "\..\Models\Comment.php";
require_once __DIR__ . "\..\Models\User.php";
require_once __DIR__ . "\..\Models\Rating.php";

// Factory für das Bewertungs-/Kommentarsystem
class CommentFactory extends AbstractController
{
    private array $comments;
    private int $productId;

    public function __construct($productId)
    {
        parent::__construct();
        $this->productId = $productId;
        $this->comments = $this->getProductCommentsFromDatabase();
    }

    private function getProductCommentsFromDatabase()
    {
        $query = "SELECT * FROM kommentare WHERE ProductID = '" . $this->productId . "' ORDER BY ProductID DESC ";
        $result = $this->database->query($query);
        $productComments = array();

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $productComments[] = new Comment($row["Id"],$row["Inhalt"],$row["ProductID"],$row["UserId"]);
            }
        }
        return $productComments;
    }

    public function generateHtmlProductComments()
    {
        $productComments = $this->getProductCommentsFromDatabase();
        $CommentsHtml = "";

        foreach ($productComments as $productComment)
        {
            $UserId = $productComment->getUserId();

            $query = "SELECT * FROM benutzer WHERE Id = '" . $UserId . "'";
            $result = $this->database->query($query);
            $row = $result->fetch_assoc();
            if($this->productAlreadyBought($UserId)){
                $tempHtml =
                    '   
                    <hr>
                    <div class="productCommentWrapper">
                        <div class="productCommentUser">
                            <p id="verificatedComment">
                                Verifizierter Kauf 
                                <svg style="padding-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                  <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg>
                            </p>
                            
                            <p>User: '. $row["Vorname"] .' '. $row["Nachname"] .'</p>                            
                        </div>
                        <div class="productCommentInhalt">
                            <p>'. $productComment->getInhalt() .'</p>
                        </div>
                        
                    </div>                    
                ';
            }
            else{
                $tempHtml =
                    '   
                    <hr>
                    <div class="productCommentWrapper">
                        <div class="productCommentUser">
                            <p>User: '. $row["Vorname"] .' '. $row["Nachname"] .'</p>
                        </div>
                        <div class="productCommentInhalt">
                            <p>'. $productComment->getInhalt() .'</p>
                        </div>
                    </div>                    
                ';
            }


            $CommentsHtml = $CommentsHtml . $tempHtml;
        }
        return $CommentsHtml;
    }

    public function addComment()
    {
        User::validateUserRequest($this->user);

        $content = $this->request->POST("commentText");
        $userId = $this->request->SESSION("userID");
        $productId = $this->request->SESSION("productId");

        $query = "INSERT INTO kommentare VALUES('','$content', '$productId', '$userId')";
        $this->database->query($query);
        $this->errorHandler->setErrorMessage("");
        header("Location: http://Localhost/WebundMultimedia/product/$productId");
        die();
    }

    public function rateProduct()
    {
        User::validateUserRequest($this->user);

        $productId = $this->request->SESSION("productId");
        $userId = $this->request->SESSION('userID');
        $rating = $this->request->GET("rating");

        if ($userId)
        {
            if (!$this->checkIfProductIsAlreadyRated($productId, $userId))
            {
                $query = "INSERT INTO bewertungen VALUES('','$rating', '$productId', '$userId')";
                $this->database->query($query);
            }
            else
            {
                $errorMessage = new ErrorMessages();
                $errorMessage->setErrorMessage("Sie haben das Produkt bereits bewertet!");
            }
        }

        header("Location: http://Localhost/WebundMultimedia/product/$productId");
        die;
    }

    public function productAlreadyBought($userId){
        $productId = $this->request->SESSION("productId");
        $query = "SELECT * FROM bestellungen WHERE BenutzerId = '$userId' AND ProduktId = '$productId'";
        $result = $this->database->query($query);

        return($result->num_rows > 0);
    }

    public function getAverageRating(): string
    {

        $query = "SELECT (SUM(bewertungen.Rating) / (SELECT COUNT(*) FROM bewertungen WHERE ProductID = '$this->productId')) as Average 
FROM bewertungen WHERE ProductID = '$this->productId'";
        $result = $this->database->query($query);

        if ($result->num_rows > 0)
        {
            $avgNumber = $result->fetch_assoc()["Average"];
            if(is_null($avgNumber))
            {
                return "Bisher gibt es keine Bewertungen<br>für dieses Produkt.";
            }
            return "Durchschnittsbewertung:<br>" .number_format($avgNumber, 1, '.', ''). " von 5 " .
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-star" viewBox="0 0 16 16" style="margin-bottom: 6px;">
                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                 </svg>';
        }



    }

    private function checkIfProductIsAlreadyRated($productId, $userId)
    {
        $query = "SELECT * FROM bewertungen WHERE ProductID = '" . $productId . "' AND BenutzerID = '$userId'";
        $result = $this->database->query($query);

        return $result->num_rows > 0;
    }

}