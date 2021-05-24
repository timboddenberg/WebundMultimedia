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
            console.log("deubg: refreshed!");
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

    /*
        Slider
     */

    var childrenIndex = 0;
    $("#sliderWrapper").children().css("display","none");
    slide(childrenIndex);

    function slide(childrenIndex)
    {
        var slider = $("#sliderWrapper").children();
        var opacity = 0;

        var pixel = -200;

        var slideInLeftInterval = setInterval(function(){

            animateSlide(slider[childrenIndex], pixel)
            pixel+=2;

            if (opacity < 1)
                opacity += 0.01;

            $(slider[childrenIndex]).css("opacity",opacity);
            $(slider[childrenIndex]).css("display","inline-block");

            if(pixel > -50){
                window.clearInterval(slideInLeftInterval);
                var slideStayCenterInterval = setInterval(function (){
                    animateSlide(slider[childrenIndex],pixel);
                    pixel += 0.1;
                    if(pixel > 50){
                        window.clearInterval(slideStayCenterInterval);
                        var slideOutRight = setInterval( function (){
                            animateSlide(slider[childrenIndex],pixel);
                            pixel++;
                            if (pixel > 100)
                            {
                                $(slider[childrenIndex]).css("opacity",opacity);
                                opacity -= 0.01;
                            }
                            if (pixel > 200)
                            {
                                window.clearInterval(slideOutRight);
                                $(slider[childrenIndex]).css("display","none");

                                if (childrenIndex === (slider.length - 1))
                                {
                                    childrenIndex = -1
                                }
                                slide(childrenIndex+1);
                            }
                        },1);
                    }
                }, 4);
            }
        }, 1);
    }

    function animateSlide(element, pixel)
    {
        element.style.marginLeft = pixel+"px";
    }
});