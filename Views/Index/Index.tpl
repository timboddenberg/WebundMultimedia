<div class="brand-Headline-Index">
    -Firmenname-
</div>
<div class="brand-Headline-Index-Subtext">
    Find your individual masterpiece
</div>

<div id="sliderWrapper">
    <div class="imageSlideWrapper">
        <img src="Images/productImage3.jpg" style="width: 200px;"/>
    </div>
    <div class="imageSlideWrapper">
        <img src="Images/productImage4.jpg" style="width: 200px;"/>
    </div>
    <div class="imageSlideWrapper">
        <img src="Images/productImage5.png" style="width: 200px;"/>
    </div>
</div>


<script>
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
</script>