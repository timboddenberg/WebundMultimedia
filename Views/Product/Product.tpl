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
                <button id="inCartButton" type="button"><span>In den Einkaufswagen!</span></button>
            </div>
        </div>
    </div>
</div>

<div class="productComments">
    <p>Kommentare</p>
    {$comments}
</div>

