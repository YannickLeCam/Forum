<?php
$userSelected= $result['data']['userSelected'];
$userSelectedTopics = $result['data']['userSelectedTopics'];
$userSelectedPosts = $result['data']['userSelectedPosts'];
$user = $result['data']['user'];

use App\Session;

?>

<a href="./index.php?ctrl=security&action=listuser"class="transparentButton"><i class="fa-solid fa-arrow-left"></i></a>

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

$now = new \DateTime();
$bannedUntil = new \DateTime($userSelected->getBanned());
if ($userSelected->getBanned() == null || $now > $bannedUntil) {
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

<div id="postsList">
<?php
foreach($userSelectedPosts as $userSelectedPost){ ?>
    <div class="postContainer">
        <div class="postUserInfo">
            <?php 
            if ($userSelectedPost->getUser()==null) {
                echo "<span class='username'>Deleted User </span>";
            }else {
                if (SESSION::isAdmin()) {
                    echo " <a class'username' href='./index.php?ctrl=security&action=userDetail&id={$userSelectedPost->getUser()->getId()}'>{$userSelectedPost->getUser()} </a>";
                }
                else {
                    echo "<span class='username'>{$userSelectedPost->getUser()} </span>";
                }
            }
            ?>
            <?=" - ".$userSelectedPost->getCreationDate()?>
            <?php
            if ($userSelectedPost->getUser()==null) {
                if (SESSION::isAdmin()) {
                    $userSelectedPostId = $userSelectedPost->getId();
                    $topicId = $userSelectedPost->getTopic()->getId();
                    echo <<<HTML
                    <div class="menuButtonUser">
                        <form action="./index.php?ctrl=forum&action=listPostsByTopic&id=$topicId&idPost=$userSelectedPostId" method="post">
                            <button type="submit" name="deletePost" class="transparentButton deletePostButton"> <i class='fa-solid fa-trash'></i> </button>
                        </form>
                    </div>
HTML;
                }
            }else {
                if ($user->getId()==$userSelectedPost->getUser()->getId() || SESSION::isAdmin()) {
                    $userSelectedPostId = $userSelectedPost->getId();
                    $topicId = $userSelectedPost->getTopic()->getId();
                    echo <<<HTML
                    <div class="menuButtonUser">
                        <form action="./index.php?ctrl=forum&action=listPostsByTopic&id=$topicId&idPost=$userSelectedPostId" method="post">
                            <button type="submit" name="deletePost" class="transparentButton deletePostButton"> <i class='fa-solid fa-trash'></i> </button>
                        </form>
HTML;
                }
                if ($user->getId()==$userSelectedPost->getUser()->getId()) {
                    echo "<button class='transparentButton editPostButton' data-post-id='$userSelectedPostId' data-topic-id='$topicId'><i class='fa-solid fa-pen-to-square' ></i></button>";
                }
                echo '</div>';
            }

            ?>
        </div>
        <div class="postMessage">
            <?=html_entity_decode($userSelectedPost->getMessage())?>
        </div>
    </div>
<?php }?>
</div>

