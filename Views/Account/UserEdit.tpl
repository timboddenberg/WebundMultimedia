<link href="/WebundMultimedia/Css/Account/Account.css" rel="stylesheet"/>
<link href="/WebundMultimedia/Css/Bootstrap/bootstrap.min.css" rel="stylesheet"/>
<link href="/WebundMultimedia/Css/Bootstrap/bootstrap-theme.min.css" rel="stylesheet"/>
<link href="/WebundMultimedia/Css/Global.css" rel="stylesheet"/>
<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<h1 class="headerText">
    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="white" class="bi bi-person headerLogo" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
    </svg>
    Accountverwaltung
</h1>
<hr>
<br>
<div class="row">
    <div class="col-md-4 userEditDetails">
        Aktuelle Accountinformationen:
        <hr>
        <div class="accountDetails">
            <span>E-Mail Adresse: <br>{$userMail}</span>
            <br>
            <hr>
            <span>Vorname: <br>{$userFirstName}</span><br>
            <hr>
            <span>Nachname: <br>{$userLastName}</span>
            <br>
            <hr>
        </div>
    </div>

    <div class="col-md-4 userEditForm">
        Account bearbeiten:
        <hr>
        <form action="/WebundMultimedia/user/performUserEdit" method="post">
            <input type="email" name="email" placeholder="Neue E-Mail Adresse" >
            <br><br>
            <input type="text" name="firstname" placeholder="Neuer Vorname" >
            <br><br>
            <input type="text" name="lastname" placeholder="Neuer Nachname" >
            <br><br>
            <input type="submit" value="Informationen aktualisieren"><br>
        </form>
    </div>

    <div class="col-md-4 userEditForm">
        Passwort ändern:
        <hr>
        <form action="/WebundMultimedia/user/performPasswordChange" method="post">
            <input type="text" name="oldpassword" placeholder="Altes Passwort" required>
            <br><br>
            <input type="text" name="newpassword" placeholder="Neues Passwort" required>
            <br><br>
            <input type="text" name="newpasswordtwo" placeholder="Neues Passwort erneut eingeben" required>
            <br><br>
            <input type="submit" value="Passwort aktualisieren"><br>
        </form>
    </div>

    <div class="row deleteAccountButtonWrapper">
        <a id="deleteAccountButton" href="/WebundMultimedia/user/remove">
            Account löschen
        </a>
    </div>
</div>

