<?php
$userSelected= $result['data']['userSelected'];
$userSelectedTopics = $result['data']['userSelectedTopics'];
$userSelectedPosts = $result['data']['userSelectedPosts'];
$user = $result['data']['user'];

var_dump($userSelected);
var_dump($userSelectedTopics);
var_dump($userSelectedPosts);


use App\Session;


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
        <input type="number" name="number" class="" id="">
        <select name="duration" id="">
            <option value="hour">heures</option>
            <option value="day">jours</option>
            <option value="month">mois</option>
            <option value="year">année</option>
            <option value="life">vie</option>
        </select>
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

<div id="tableTopics">
    <table>
        <thead>
            <td>Sujet</td>
            <td>Auteur <br> Date de creation</td>
            <td>Supprimer</td>
        </thead>
        <tbody>
        <?php
        if ($userSelectedTopics) {
            foreach($userSelectedTopics as $userSelectedTopic ){ 
                ?>
            <tr>
                <td>
                    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $userSelectedTopic->getId() ?>"> <span class="titleTopic"> <?= $userSelectedTopic ?> </span> </a>
                </td>
                <td><?= $userSelectedTopic->getUser() ? $userSelectedTopic->getUser() : "Deleted User" ?> <br> <?=$userSelectedTopic->getCreationDate()?></td>
                <td>                    
                    <?php
                        if ($userSelectedTopic->getUser()==null) { 
                            if (SESSION::isAdmin()) { 
                        ?>
                            <form action="./index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$userSelectedTopic->getCategory()?>&idTopic=<?=$userSelectedTopic->getId()?>" method="post">
                                <button type="submit" name="deleteTopic" class="transparentButton deleteTopic"><i class="fa-solid fa-trash"></i></button>
                            </form>    
                        <?php }
                            ?>
                        <?php } else {
                            if ($user->getId()=== $userSelectedTopic->getUser()->getId() || SESSION::isAdmin()) { 
                                ?>
                                        <form action="./index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$userSelectedTopic->getCategory()?>&idTopic=<?=$userSelectedTopic->getId()?>" method="post">
                                            <button type="submit" name="deleteTopic" class="transparentButton deleteTopic"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                <?php } 
                        }
                    ?>
                </td>
            </tr>
        <?php }} ?>
        </tbody>
    </table>
</div>

<h2> Les posts</h2>

<?php
foreach ($userSelectedPosts as $post) {
    var_dump($post);
}
?>
