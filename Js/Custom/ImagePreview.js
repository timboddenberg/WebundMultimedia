$(document).ready(function (){
    $("#triggerImageUpload").click(function (){
        $("#imageInputField").click();
    });

    $("#imageInputField").change(function (){
        if (this.files)
        {
            var fileReader = new FileReader();

            fileReader.addEventListener("load", function() {
                $("#productImagePlaceholder").replaceWith('<img class="imagePreview" src="' + fileReader.result + '">');
            });

            fileReader.readAsDataURL(this.files[0]);
        }
    });

    $("#submitProductUpload").click(function (event) {
        event.preventDefault();

        if ($("#imageInputField").val() != "")
        {
            $("#productUploadForm").submit();
        }
        else
        {
            $("#productImagePlaceholder").addClass("shake");

            setTimeout(function (){
                $("#productImagePlaceholder").removeClass("shake");
            },1000);
        }
    })

});