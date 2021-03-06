<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<h1 class="headerText">
    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-shop headerLogo" viewBox="0 0 16 16">
        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
    </svg>
    Produkt editieren
</h1>
<hr>
<br>

<div class="row productListWrapper">
    <div class="productImageList col-md-4">
        <img src="{$BildURL}">
    </div>
    <div class="productNameList col-md-4">
        Produktname: <br>{$Name}
    </div>
    <div class="productNameList col-md-4">
        Beschreibung: {$Beschreibung}
    </div>
</div>
<hr>
<br>

<div class="row productAdministrationContentWrapper">
    <div class="col-md-12">
        <form  class="right" method="post" action="/WebundMultimedia/admin/product/edit?productID={$Id}" enctype="multipart/form-data" id="productEditForm">
            <input type="text" placeholder="Name: {$Name}" name="name"/><br>
            <input type="text" placeholder="Preis: {$Preis} Euro" name="price"/><br>
            <input type="text" name="description" placeholder="Beschreibung: {$Beschreibung}"><br>
            <input type="text" name="brand" placeholder="Marke: {$Marke}"><br>
            <input type="text" name="color" placeholder="Farbe: {$Farbe}"><br>
            <input type="text" name="material" placeholder="Material: {$Material}"><br>
            <input type="text" placeholder="Lagerbestand: {$Bestand}" name="amount"/><br>
            <input type="file" id="editImageInputField" name="image" /><br>
            <input type="submit" id="submitEditProduct"/>
        </form>
    </div>
</div>

