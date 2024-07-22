<?php
$topics = $result['data']['topics'];
$categories = $result["data"]['categories']; 


?>

<h1>Les topics</h1>
<?php
foreach ($topics as $topic) {
    var_dump($topic);
    echo '<br>';
    echo '<br>';
}
?>

<h1>Catégories</h1>
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

