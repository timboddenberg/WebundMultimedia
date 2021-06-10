<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<div class="addCommentForm">
    <p>Kommentar für Produkt {$Name}</p>
    <form class="" action="/WebundMultimedia/product/addComment/submit" method="post">
        <textarea name="commentText" placeholder="Kommentar" id="CommentArea" rows="6" required></textarea>
        <br>
        <input type="submit" value="Kommentar abschicken" id="CommentSubmit"><br>
    </form>
</div>