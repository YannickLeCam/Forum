<?php
    $categories = $result["data"]['categories']; 

?>

<div id="tableCategory">


    <table>
        <thead>
            <td> Titre </td>
            <td> Derniere activitée</td>
            <td> Nombre de Topic(s) <br> Nombre de Post(s)</td>
        </thead>
        <tbody>
        <?php
        foreach($categories as $categoryWithLastTopic ){ 
            $category = $categoryWithLastTopic[0];
            $lastTopic = $categoryWithLastTopic[1];
            ?>
            <tr>
                <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><span class="titleCategory"><?= $category->getName()?> </span> <br> <?= $category->getDescription()?></a></td>
                
                <?php
                if ($lastTopic!==null) {?>
                    <td><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $lastTopic->getId() ?>"> <i class="fa-solid fa-chevron-right"></i> <?=$lastTopic->getTitle()?></a></td>

                <?php }else { ?>
                    <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"></a></td>
                <?php }
                ?>
                <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"> <?=$category->getNbTopics()?> <br>  <?=$category->getNbPosts()?></a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

  
