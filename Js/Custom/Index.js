$(document).ready(function (){

    /*
        Error Messages
     */
    var errorMessageElement = $(".errorMessage");

    if (errorMessageElement.length > 0)
    {
        setTimeout(function () {
            $(".errorMessage").fadeOut();
        },3000);
    }

    /*
        Handle Menu
     */

    $("#openOverlay").click(function (){
        $(".menuOverlay").addClass("menuOverlayOpened");
        $(".menuContentWrapper").css("padding","40px");
    });

    $("#closeOverlay").click(function (){
        $(".menuOverlay").removeClass("menuOverlayOpened");
        $(".menuContentWrapper").css("padding","0");
    });

    /*
    searches for the product what the users enters into the searchbar and pauses when the user does to many requests
    */

    var results;
    var searchTerm;
    var oldSearchTerm;

    $('#search').keydown(function (event)
    {
        oldSearchTerm = searchTerm;
        searchTerm = ($('#search').val() + String.fromCharCode(event.keyCode)).toLowerCase();

        var refreshResults;

        if (oldSearchTerm === undefined)
            refreshResults = true;
        else
            refreshResults = !searchTerm.includes(oldSearchTerm);

        $(".searchResults").empty();

        if (refreshResults)
        {
            $.ajax({
                async: false,
                data:{
                    "searchTerm": searchTerm
                },
                url:'http://localhost/WebundMultimedia/search',
                success: function(result){
                    results = JSON.parse(result);
                }
            });
        }

        for (var i = 0; i < results.length; i++)
        {
            var productName = results[i].Name;
            productName = productName.toLowerCase();
            if (productName.includes(searchTerm))
                $(".searchResults").append("<div class='searchBarResult'><a href='http://localhost/WebundMultimedia/product/" + results[i].Id + "'>" + results[i].Name + "</a></div>");
        }
    });

});