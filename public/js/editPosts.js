
document.querySelectorAll('.editPostButton').forEach(button => {
    
    button.addEventListener('click', function() {
        this.style.display="none";
        const postId = this.getAttribute('data-post-id');
        const topicId = this.getAttribute('data-topic-id');
        const postContainer = this.closest('.postContainer');
        const messageElement = postContainer.querySelector(`.postMessage`);
        const originalContent = messageElement.innerHTML.trim();

        // Remove existing TinyMCE instance if any
        if (tinymce.get(`editor-${postId}`)) {
        tinymce.get(`editor-${postId}`).remove();
        }

        // Replace the message content with a textarea
        messageElement.outerHTML = `
            <form action="./index.php?ctrl=forum&action=listPostsByTopic&id=${topicId}&idPost=${postId}" method="post" class="edit-post-form postMessage">
                <textarea id="editor-${postId}" name="message">${originalContent}</textarea>
                <div id='editMenuButton'>
                    <button type="button" class="btn btn-danger cancelButton">Annuler</button>
                    <button type="submit" name="submitEdit" class="btn btn-success"> Valider </button>
                </div>        
            </form>
        `;

        // Initialize TinyMCE on the new textarea
        tinymce.init({
            selector: `#editor-${postId}`,
            menubar: false,
            plugins: 'link image code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
        });

        // Add event listener to the cancel button
        document.querySelector('.cancelButton').addEventListener('click', function() {
            const form = this.closest('form');
            postContainer.querySelector('.editPostButton').style.display = "block";
            form.outerHTML = `<div class='postMessage' id="message-${postId}">${originalContent}</div>`;
        });
    });
});