<?php
use APP\Session;
?>

<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<input type="text" name="sdfqs" placeholder="<?=SESSION::getCsrfToken()?>" id="">
<?php
var_dump($_SESSION['csrf_']);
?>

<p>
    <a href="index.php?ctrl=security&action=login">Se connecter</a>
    <a href="index.php?ctrl=security&action=register">S'inscrire</a>
</p>