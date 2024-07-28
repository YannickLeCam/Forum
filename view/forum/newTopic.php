<?php
    //$user = $_SESSION['user'];
    $category = $result['data']['category']

?>

<script>
    tinymce.init({
        selector: 'textarea#default-editor',
        setup: function (editor) {
                editor.on('focus', function () {
                    editor.getContainer().closest('.tinyMCE').classList.add('focused');
                });
                editor.on('blur', function () {
                    editor.getContainer().closest('.tinyMCE').classList.remove('focused');
                });
        }
    });
</script>
<div class="titleNewTopic">
    <h1>Nouveau Topic</h1>
</div>


<form id="formNewTopic" action="index.php?ctrl=forum&action=newTopic&id=<?=$category->getId()?>" method="post" onsubmit="submitForm()">
    
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="title" id="floatingInputPseudo" placeholder="Titre du topic">
        <label for="floatingInputPseudo">Titre du topic</label>
    </div>

    <div class="tinyMCE">
        <textarea id="default-editor" name="message" placeholder="Entrer votre message ici . . .">
        </textarea>
    </div>


    <input type="submit" class="submitMessage" name="submitNewTopic" value="Publier">
</form>






<script>
    function submitForm() {
        // Récupère le contenu de TinyMCE
        var content = tinymce.get('mytextarea').getContent();
        // Place le contenu dans le textarea
        document.getElementById('mytextarea').value = content;
    }
</script>
