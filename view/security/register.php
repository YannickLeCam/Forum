<h1>Inscription</h1>

<form action="./index.php?ctrl=security&action=register" method="post">
    
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInputPseudo" placeholder="Pseudo">
        <label for="floatingInputPseudo">Pseudo</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="floatingInputMail" placeholder="name@example.com">
        <label for="floatingInputMail">Email address</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe">
        <label for="floatingPassword">Mot de passe</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Confirmation du mot de passe">
        <label for="floatingPasswordConfirm">Confirmation du mot de passe</label>
    </div>

    <input type="submit" class="btn btn-primary" name="submitRegister" value="S'inscrire">
</form>