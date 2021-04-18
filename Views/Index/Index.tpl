{extends "../Layout.tpl"}

{block body}

    <div class="brand-Headline-Index">
        -Firmenname-
    </div>
    <div class="brand-Headline-Index-Subtext">
        Find your individual masterpiece
    </div>

    <div id="sliderWrapper">
        <div class="imageSlideWrapper">
            <img src="Images/productImage.jpg" style="width: 200px;"/>
        </div>
        <div class="imageSlideWrapper">
            <img src="Images/productImage.jpg" style="width: 200px;"/>
        </div>
        <div class="imageSlideWrapper">
            <img src="Images/productImage.jpg" style="width: 200px;"/>
        </div>
        <div class="imageSlideWrapper">
            <img src="Images/productImage.jpg" style="width: 200px;"/>
        </div>
    </div>


    <script>
        var slider = $("#sliderWrapper").children();
        slider.hide();
        $(slider[0]).fadeIn();
        var pixel = -200;

            var slideInLeftInterval = setInterval(function(){
                animateSlide(slider[0], pixel)
                pixel+=2;

                if(pixel > -50){
                    clearInterval(slideInLeftInterval);

                    var slideStayCenterInterval = setInterval(function (){
                        animateSlide(slider[0],pixel);
                        pixel += 0.1;

                        if(pixel > 50){
                            clearInterval(slideStayCenterInterval);

                            var slideOutRight = setInterval( function (){
                                animateSlide(slider[0],pixel);
                                pixel++;
                                if (pixel > 180)
                                {
                                    $(slider[0]).fadeOut(2000);
                                }
                                if (pixel > 200)
                                {
                                    clearInterval(slideOutRight);
                                }
                            },1);
                        }
                    }, 4);

                }

            }, 1)

        function animateSlide(element, pixel)
        {
            element.style.marginLeft = pixel+"px";
        }
    </script>

{/block}