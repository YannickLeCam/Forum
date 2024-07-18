<?php
use App\Session;
//SESSION::setCsrfToken();
var_dump($_SESSION);
?>
<h1>Connexion</h1>


<form action="./index.php?ctrl=security&action=login" method="post">
        <?=var_dump($_SESSION['csrf_'])?>
    <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="floatingInputMail" placeholder="name@example.com">
            <label for="floatingInputMail">Email address</label>
    </div>
    <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Mot de passe">
            <label for="floatingPassword">Mot de passe</label>    
    </div>

    <input type="submit" class="btn btn-primary" name="submitLogin" value="Se connecter">

    <input type="hidden" name="csrf_" value="<?=$_SESSION['csrf_']?>">

    <input type="text" name="jsuispasunhoneypot" style="display:none">

</form>
