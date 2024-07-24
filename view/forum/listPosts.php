<?php 
use APP\Session;
$topic= $result['data']['topic'];
$posts= $result['data']['posts'];
$nbPages= $result['data']['nbPages'];
$page= $result['data']['page'];
$user = $result['data']['user'];
$idTopic = $topic->getId();
if ($page == null) {
    $page=1;
}

?>
<div id="menuPostList">

    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$topic->getCategory()->getId()?>" class="transparentButton"><i class="fa-solid fa-arrow-left"></i></a>
    <?php
if ($user->getId()=== $topic->getUser()->getId() || SESSION::isAdmin()) {
    if ($topic->getClosed() == 0) {
        echo <<<HTML
        <form action="index.php?ctrl=forum&action=listPostsByTopic&id=$idTopic" method="post">
            <input type="submit" name="closeTopic" class="btn btn-warning" value="Fermer le topic">
        </form>
    HTML;
    }if ($topic->getClosed() == 1) {
        echo <<<HTML
        <form action="index.php?ctrl=forum&action=listPostsByTopic&id=$idTopic" method="post">
            <input type="submit" name="closeTopic" class="btn btn-success" value="Réouvrir le topic">
        </form>
    HTML;
    }
}
?>

</div>

<div class="topicTitle">
        <h2><?=$topic?></h2>
</div>
<div id="postsList">
<?php
foreach($posts as $post ){ ?>
    <div class="postContainer">
        <div class="postUserInfo">
            <?php 
            if (SESSION::isAdmin()) {
                echo " <a class'username' href='./index.php?ctrl=security&action=userDetail&id={$post->getUser()->getId()}'>{$post->getUser()} </a>";
            }
            else {
                echo "<span class='username'>{$post->getUser()} </span>";
            }
            ?>
            <?=" - ".$post->getCreationDate()?>
            <?php
            if ($user->getId()==$post->getUser()->getId() || SESSION::isAdmin()) {
                $postId = $post->getId();
                $topicId = $topic->getId();
                echo <<<HTML
                <div class="menuButtonUser">
                    <form action="./index.php?ctrl=forum&action=listPostsByTopic&id=$topicId&idPost=$postId" method="post">
                        <button type="submit" name="deletePost" class="transparentButton deletePostButton"> <i class='fa-solid fa-trash'></i> </button>
                    </form>
                    <button class="transparentButton editPostButton" data-post-id="$postId" data-topic-id="$topicId"><i class="fa-solid fa-pen-to-square" ></i></button>
                </div>
HTML;
            }
            ?>
        </div>
        <div class="postMessage">
            <?=html_entity_decode($post->getMessage())?>
        </div>
    </div>
<?php }?>
</div>
<?php
$pagePrev = $page-1;
$pageSuiv = $page+1;
?>


<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item <?=($page==null || $page == 1) ? "disabled" : ""?>">
        <?=($page==null || $page == 1) ? "<span class='page-link'>" : "<a href='index.php?ctrl=forum&action=listPostsByTopic&id={$topic->getId()}&page=$pagePrev' class='page-link'>"?> Previous <?=($page==null || $page == 1) ? "</span>" : "</a>"?>
    </li>
    <?php
        for ($i=1; $i <= $nbPages; $i++) { 
            if ($page == $i) {
                echo "<li class='page-item active'><a class='page-link' href='index.php?ctrl=forum&action=listPostsByTopic&id={$topic->getId()}&page=$i'>$i</a></li>";
            }else {
                echo "<li class='page-item'><a class='page-link' href='index.php?ctrl=forum&action=listPostsByTopic&id={$topic->getId()}&page=$i'>$i</a></li>";
            }
        }
    ?>
    <li class="page-item <?=($page==$nbPages) ? "disabled" : ""?>">
      <?=($page==$nbPages) ? "<span class='page-link'>" : "<a href='index.php?ctrl=forum&action=listPostsByTopic&id={$topic->getId()}&page=$pageSuiv' class='page-link'>"?> Next <?=($page==$nbPages) ? "</span>" : "</a>"?>
    </li>
  </ul>
</nav>

<script>
    tinymce.init({
        selector: 'textarea#default-editor'
    });
</script>





<?php
    if ($topic->getClosed()==0) {
        echo <<<HTML
    <form class='formNewMessage' action="index.php?ctrl=forum&action=listPostsByTopic&id={$topic->getId()}"" method="post" onsubmit="submitForm()">
        <label for="default-editor">Votre message :</label>
        <textarea id="default-editor" name="message" placeholder="Entrer votre message ici . . .">
        </textarea>
        <input type="submit"  name="submitNewPost" class="submitMessage" value="Publier">
    </form>
HTML;
    }
?>



<script src="./public/js/editPosts.js"></script>






<script>
    function submitForm() {
        // Récupère le contenu de TinyMCE
        var content = tinymce.get('mytextarea').getContent();
        // Place le contenu dans le textarea
        document.getElementById('mytextarea').value = content;
    }
</script>
