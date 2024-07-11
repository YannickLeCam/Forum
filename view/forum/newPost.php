<?php
    $topic = $result['data']['topic'];
    //$user = $_SESSION['user'];
    $post = $result['data'];




?>



<script>
    tinymce.init({
        selector: 'textarea#default-editor'
    });
</script>


<form method="post" action="index.php?ctrl=forum&action=newPost&id=<?=$topic->getId()?>" onsubmit="submitForm()">

    <label for="default-editor">Votre message :</label>
    <textarea id="default-editor" placeholder="Entrer votre message ici . . .">
    </textarea>

    <input type="submit" name="submitNewPost" value="Publier">
</form>

<script>
    function submitForm() {
        // Récupère le contenu de TinyMCE
        var content = tinymce.get('mytextarea').getContent();
        // Place le contenu dans le textarea
        document.getElementById('mytextarea').value = content;
    }
</script>
