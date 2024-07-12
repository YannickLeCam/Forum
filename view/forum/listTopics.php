<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    var_dump($category,$topics);
?>

<h1>Liste des topics</h1>
<a href="./index.php?ctrl=forum&action=newTopic&id=<?=$category->getId()?>" class="btn btn-success">Nouveau topic</a>
<?php

foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
<?php }
