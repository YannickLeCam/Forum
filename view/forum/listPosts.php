<?php 
$topic= $result['data']['topic'];
$posts= $result['data']['posts'];

?>

<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$topic->getId()?>" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
<?php
foreach($posts as $post ){ ?>
    <li>username : <?=$post->getUser()?></li>
    <li>date de création : <?=$post->getCreationDate()?></li>
    <li>message : <?=$post->getMessage()?></li>
    <br>
<?php }?>


<script>
    tinymce.init({
        selector: 'textarea#default-editor'
    });
</script>

<form " action="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"" method="post" onsubmit="submitForm()">
    <label for="default-editor">Votre message :</label>
    <textarea id="default-editor" name="message" placeholder="Entrer votre message ici . . .">
    </textarea>

    <input type="submit"  name="submitNewPost" value="Publier">
</form>






<script>
    function submitForm() {
        // Récupère le contenu de TinyMCE
        var content = tinymce.get('mytextarea').getContent();
        // Place le contenu dans le textarea
        document.getElementById('mytextarea').value = content;
    }
</script>
