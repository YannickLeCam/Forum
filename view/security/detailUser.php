<?php
$userSelected= $result['data']['userSelected'];
$userSelectedTopics = $result['data']['userSelectedTopics'];
$userSelectedPosts = $result['data']['userSelectedPosts'];

var_dump($userSelected);
var_dump($userSelectedTopics);
var_dump($userSelectedPosts);



?>

<a href="./index.php?ctrl=security&action=listuser">← Retour</a>

<h2>Informations</h2>



<?php

if ($userSelected->getRole()=="USER") {
    echo <<<HTML
    <form action="./index.php?ctrl=security&action=userDetail&id=1" method="post">
        <label for="">Passer l'utilisateur en :</label>
        <input type="submit" name="submitButtonAddAdmin" class="btn btn-primary" value="Admin">
    </form>
HTML;
}

if ($userSelected->getBanned()==null) {
    echo <<<HTML
    <form action="./index.php?ctrl=security&action=userDetail&id=1" method="post">
        <input type="submit" name="submitButtonBan" class="btn btn-danger" value="Bannir l'utilisateur">
    </form>
HTML;
}else {
    echo <<<HTML
    <form action="./index.php?ctrl=security&action=userDetail&id=1" method="post">
        <input type="submit" name="submitButtonUnban" class="btn btn-success" value="Debannir l'utilisateur">
    </form>
HTML;
}

?>

<h2>Les topics</h2>

<?php
foreach ($userSelectedTopics as $topic) {
    var_dump($topic);
}
?>

<h2> Les posts</h2>

<?php
foreach ($userSelectedPosts as $post) {
    var_dump($post);
}
?>
