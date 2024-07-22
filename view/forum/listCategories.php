<?php
    $categories = $result["data"]['categories']; 

?>

<h1>Liste des catégories</h1>
<div id="tableCategory">


    <table>
    <?php
    foreach($categories as $category ){ ?>
        <tr>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></td>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"> Nombres de topic : <?=$category->getNbTopics()?></a></td>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"> Nombres de ports : <?=$category->getNbPosts()?></a></td>
            <td><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"> Dernier topic modifié <?=$category->getNbPosts()?></a></td>
        </tr>
    <?php } ?>
    </table>

</div>

  
