<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<div class="productDetails">
    <div class="productPicture">
        <img src="{$BildURL}"/>
    </div>
    <div class="productInfo">
        <div class="productTitle">{$Name}</div>
        <hr>
        <div class="productDescription">{$Beschreibung}</div>
        <hr>
        <div>
            <div class="productPrice">Preis: {$Preis}€</div>
            <div>
                <button id="inCartButton" type="button"><span>In den Einkaufswagen!</span> </button>
            </div>
        </div>
    </div>
</div>
<div>
    <p id="nonvisibleid">{$Id}</p>
</div>
<script>
    //calls the shopping cart route with the id of the item, when the user hits the button
    var id = document.getElementById("nonvisibleid").innerHTML;
    var button = document.getElementById("inCartButton");
    button.onclick = function (){
        location.assign('http://localhost/WebundMultimedia/product/addtoshoppingcart?id=' + id);
    }
</script>
<div class="productComments">
    <p style="font-size: 25px">Kommentare</p>
    <div>
        <a id="newCommentButton" type="button" href="/WebundMultimedia/product/addComment?id={$Id}" ><span>Kommentar erstellen</span></a>
    </div>
    <br>
    {$comments}
</div>
<br>

