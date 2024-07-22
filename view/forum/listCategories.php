<?php
    $categories = $result["data"]['categories']; 

?>

<h1>Liste des catégories</h1>
<div id="tableCategory">


    <table>
    <?php
    foreach($categories as $categoryWithLastTopic ){ 
        $category = $categoryWithLastTopic[0];
        $lastTopic = $categoryWithLastTopic[1];
        ?>
        <tr>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></td>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"> Nombres de topic : <?=$category->getNbTopics()?> <br> Nombres de posts : <?=$category->getNbPosts()?></a></td>
            <?php
            if ($lastTopic!==null) {?>
                <td><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $lastTopic->getId() ?>"> Derniere activitée : <?=$lastTopic->getTitle()?></a></td>

            <?php }else { ?>
                <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"></a></td>
            <?php }
            ?>
        </tr>
    <?php } ?>
    </table>

</div>

  
