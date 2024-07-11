<?php 
$topic= $result['data']['topic'];
$posts= $result['data']['posts'];

?>

<?php
foreach($posts as $post ){ ?>
    <li>username : <?=$post->getUser()?></li>
    <li>date de création : <?=$post->getCreationDate()?></li>
    <li>message : <?=$post->getMessage()?></li>
    <br>
<?php }?>

<a href="index.php?ctrl=forum&action=newPost&id=<?= $topic->getId() ?>">Ajouter un post</a>