<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<div class="productAdministrationHeadlineWrapper row">
    <div class="productAdministrationHeadline">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
        </svg>
        <span>Produktverwaltung</span>
    </div>
</div>


<div class="row productAdministrationContentWrapper">


    <div class="col-md-6">
        <div id="triggerImageUpload">
            <div id="productImagePlaceholder">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-file-earmark-image" viewBox="0 0 16 16">
                    <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                    <path d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5V14zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4z"/>
                </svg>
            </div>
        </div>

        <form method="post" action="/WebundMultimedia/product/add" enctype="multipart/form-data" id="productUploadForm">
            <input type="text" placeholder="Name" name="name" required/><br>
            <input type="text" placeholder="Preis" name="price" required/><br>
            <input type="text" name="description" placeholder="Beschreibung"><br>
            <input type="text" name="brand" placeholder="Marke"><br>
            <input type="text" name="color" placeholder="Farbe"><br>
            <input type="text" name="material" placeholder="Material"><br>
            <input type="text" placeholder="Lagerbestand" name="amount" required/><br>
            <input type="file" id="imageInputField" name="image" required/><br>
            <input type="submit" id="submitProductUpload"/>
        </form>
    </div>

    <div class="col-md-6" style="border: 1px solid white; border-radius: 10px;">
        {$productList}
    </div>


</div>
<script src="/WebundMultimedia/Js/Custom/ImagePreview.js"></script>