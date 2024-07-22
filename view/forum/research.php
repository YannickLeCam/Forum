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

<h1>Les catégories</h1>
<?php
foreach ($categories as $category) {
    var_dump($category);
    echo '<br>';
    echo '<br>';
}
?>

