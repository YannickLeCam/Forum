<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    var_dump($category,$topics);
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $category->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
<?php }
