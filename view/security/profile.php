<?php
$user= $result['data']['user'];
?>

<h4>Bonjour <?=$user?></h4>

<form action="./index.php?ctrl=security&action=profile" method="post">
    <div class="form-floating mb-3">
            <input type="text" class="form-control" name="nickName" id="floatingInputPseudo" placeholder="Modifier son pseudo">
            <label for="floatingInputPseudo">Modifier son pseudo</label>
    </div>

    <input type="submit" name="submitEditNickName" class="btn btn-primary" value="Modifier" >
</form>


<form action="./index.php?ctrl=security&action=profile" method="post">
    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Mot de passe">
        <label for="floatingPassword">Mofifier le mot de passe</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="passwordConfirm" id="floatingPasswordConfirm" placeholder="Confirmation du mot de passe">
        <label for="floatingPasswordConfirm">Confirmation du mot de passe</label>
    </div>

    <input type="submit" name="submitEditPassword" class="btn btn-primary" value="Modifier" >
</form>

<form action="./index.php?ctrl=security&action=profile" method="post">
    <input type="submit" class="btn btn-danger" id='deleteAccountButton' name="deleteAccount" value="Supprimer le compte">
</form>


