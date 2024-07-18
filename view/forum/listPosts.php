<?php 
use APP\Session;
$topic= $result['data']['topic'];
$posts= $result['data']['posts'];
$user = SESSION::getUser();

?>

<a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$topic->getCategory()->getId()?>" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>

<?php
foreach($posts as $post ){ ?>
    <div class="postContainer">
        <?php if ($user->getId()==$post->getUser()->getId() || SESSION::isAdmin()) {
            $postId = $post->getId();
            $topicId = $topic->getId();
            echo <<<HTML
        <form action="./index.php?ctrl=forum&action=listPostsByTopic&id=$topicId&idPost=$postId" method="post">
            <input type="submit" name="deletePost" class="btn btn-danger" value="Delete">
        </form>
        <button class="btn btn-warning editPostButton" data-post-id="$postId" data-topic-id="$topicId">Modifier</button>
HTML;
        }?>

        <li>username : <?=$post->getUser()?></li>
        <li>date de création : <?=$post->getCreationDate()?></li>
        <li class='postMessage'><?=$post->getMessage()?></li>
        <br>
    </div>
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

<script src="./public/js/editPosts.js"></script>






<script>
    function submitForm() {
        // Récupère le contenu de TinyMCE
        var content = tinymce.get('mytextarea').getContent();
        // Place le contenu dans le textarea
        document.getElementById('mytextarea').value = content;
    }
</script>
