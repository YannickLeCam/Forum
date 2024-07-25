const deleteButtonsTopics = document.getElementsByClassName('deleteTopic');

for (let index = 0; index < deleteButtonsTopics.length; index++) {
    const element = deleteButtonsTopics[index];
    element.addEventListener('click',function(event){
        event.preventDefault();
        
        const myForm = element.closest('form');
        // Create the confirmation box
        const confirmationBox = document.createElement('div');
        confirmationBox.id = 'confirmationBox';
        
        // Create the message
        const message = document.createElement('p');
        message.textContent = 'Êtes-vous sûr de vouloir supprimer le topic ?';
        confirmationBox.appendChild(message);

        // Create the confirm button
        const confirmButton = document.createElement('button');
        confirmButton.textContent = 'Oui';
        confirmButton.style.marginRight = '10px';
        confirmationBox.appendChild(confirmButton);

        // Create the cancel button
        const cancelButton = document.createElement('button');
        cancelButton.textContent = 'Non';
        confirmationBox.appendChild(cancelButton);

        // Position the confirmation box near the delete button
        const rect = element.getBoundingClientRect();
        confirmationBox.style.top = `${rect.bottom + window.scrollY}px`;
        confirmationBox.style.left = `${rect.left + window.scrollX}px`;
        confirmationBox.style.display = 'block';

        document.body.appendChild(confirmationBox);

        // Handle the confirmation
        confirmButton.addEventListener('click', function() {
            confirmationBox.remove();
            // Create and append the hidden input field
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleteTopic';
            hiddenInput.value = 'true';
            myForm.appendChild(hiddenInput);
            myForm.submit();
        });

        // Handle the cancellation
        cancelButton.addEventListener('click', function() {
            confirmationBox.remove();
        });
    })
}
