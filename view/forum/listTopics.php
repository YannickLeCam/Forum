<?php
    $user = $result['data']['user'];
    $category = $result["data"]['category']; 
    $topicsWithLastPost = $result["data"]['topics']; 
    use App\Session;
?>

<div id="menuTopicsList">
    <a href="index.php?ctrl=forum&action=index" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
    <h2><?=$category?></h2>
    <a href="index.php?ctrl=forum&action=newTopic&id=<?=$category->getId()?>" class="btn btn-success">Nouveau topic</a>
</div>

<div id="tableTopics">
    
    <table>
        <thead>
            <td>Sujet</td>
            <td>Auteur <br> Date de creation</td>
            <td>Dernière activitée</td>
        </thead>
        <tbody>
        <?php
        if ($topicsWithLastPost) {
            foreach($topicsWithLastPost as $topicWithLastPost ){ 
                $topic = $topicWithLastPost[0];
                $lastPost = $topicWithLastPost[1];
                ?>
            <tr>
                <td>
                    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"> <span class="titleTopic"> <?= $topic ?> </span> </a>
                    <?php
                        if ($user->getId()=== $topic->getUser()->getId() || SESSION::isAdmin()) { ?>
                            <form action="./index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$category->getId()?>&idTopic=<?=$topic->getId()?>" method="post">
                                <button type="submit" name="deleteTopic" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                    <?php }
                    ?>

                </td>
                <td><?= $topic->getUser() ?> <br> <?=$topic->getCreationDate()?></td>
                <td><?=$lastPost->getUser()?> <br><?=$lastPost->getCreationDate()?> </td>
            </tr>
        <?php }} ?>
        </tbody>
    </table>
</div>
