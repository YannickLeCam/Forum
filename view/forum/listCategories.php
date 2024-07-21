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
            <td> Nombres de topic : <?=$category->getNbTopics()?></td>
        </tr>
    <?php } ?>
    </table>

</div>

  
