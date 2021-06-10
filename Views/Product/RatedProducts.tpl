<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<h1 class="headerText">Meine Bewertungen</h1>
<hr>
{$ratedProducts}

<script>
    $(".allProductsWrapper").click(function (){
        var productId = this.id;
        window.location.href = "/WebundMultimedia/product/" + productId;
    });
</script>