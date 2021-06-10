<link href="/WebundMultimedia/Css/Account/Account.css" rel="stylesheet"/>
<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>
<div class='row userColumnHeadline'>
    <div class='col-md-3'>
        Vorname
    </div>
    <div class='col-md-3'>
        Nachname
    </div>
    <div class='col-md-3'>
        Benutzerkategorie
    </div>
    <div class='col-md-2'>
        Adminrechte
    </div>
    <div class='col-md-1'>
        Löschen
    </div>
</div>

<div class="row userAdministrationSearchDivision">
    <div class='col-md-3'>
        <input type="text" name="firstName">
    </div>
    <div class='col-md-3'>
        <input type="text" name="lastName">
    </div>
    <div class='col-md-3'>
        <input type="text" name="category">
    </div>
</div>

<br>

<div id="userAdministrationUserColumns">

</div>

<script>

    getUserAdministrationHtml()

    $(".userAdministrationSearchDivision input").on("input",function (){

        getUserAdministrationHtml();

    });

    function getUserAdministrationHtml()
    {
        $.ajax({
            data:{
                "firstNameSearchTerm": $("input[name='firstName']").val(),
                "lastNameSearchTerm": $("input[name='lastName']").val(),
                "categorySearchTerm": $("input[name='category']").val()
            },
            url:'http://localhost/WebundMultimedia/user/administration/getAdministrationHtml',
            success: function(result){
                $("#userAdministrationUserColumns").empty();

                $("#userAdministrationUserColumns").append(result);
            }
        });
    }

</script>