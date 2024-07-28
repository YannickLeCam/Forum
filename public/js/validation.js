document.addEventListener('DOMContentLoaded', function() {
    const pseudoInput = document.getElementById('floatingInputPseudo');
    const passwordInput = document.getElementById('floatingPassword');
    const passwordConfirmInput = document.getElementById('floatingPasswordConfirm');
    const pseudoMessage = document.getElementById('pseudoMessage');
    const passwordMessage = document.getElementById('passwordMessage');
    const passwordConfirmMessage = document.getElementById('passwordConfirmMessage');

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{12,}$/;

    pseudoInput.addEventListener('input', function() {
        if (pseudoInput.value.length < 5) {
            pseudoMessage.textContent = 'Le pseudo doit comporter au moins 5 caractères.';
            pseudoMessage.style.display = 'block';
            pseudoInput.classList.add('input-error');
        } else {
            pseudoMessage.style.display = 'none';
            pseudoInput.classList.remove('input-error');
        }
    });

    pseudoInput.addEventListener('blur', function() {
        pseudoMessage.style.display = 'none';
    });

    passwordInput.addEventListener('input', function() {
        if (!passwordRegex.test(passwordInput.value)) {
            passwordMessage.textContent = 'Le mot de passe doit comporter au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
            passwordMessage.style.display = 'block';
            passwordInput.classList.add('input-error');
        } else {
            passwordMessage.style.display = 'none';
            passwordInput.classList.remove('input-error');
        }
    });

    passwordInput.addEventListener('blur', function() {
        passwordMessage.style.display = 'none';
    });

    passwordConfirmInput.addEventListener('input', function() {
        if (passwordConfirmInput.value !== passwordInput.value) {
            passwordConfirmMessage.textContent = 'Les mots de passe ne correspondent pas.';
            passwordConfirmMessage.style.display = 'block';
            passwordConfirmInput.classList.add('input-error');
        } else {
            passwordConfirmMessage.style.display = 'none';
            passwordConfirmInput.classList.remove('input-error');
        }
    });

    passwordConfirmInput.addEventListener('blur', function() {
        passwordConfirmMessage.style.display = 'none';
    });

    // Form submission validation
    const registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit', function(event) {
        let isValid = true;

        if (pseudoInput.value.length < 5) {
            isValid = false;
            pseudoMessage.style.display = 'block';
            pseudoInput.classList.add('input-error');
        }

        if (!passwordRegex.test(passwordInput.value)) {
            isValid = false;
            passwordMessage.style.display = 'block';
            passwordInput.classList.add('input-error');
        }

        if (passwordConfirmInput.value !== passwordInput.value) {
            isValid = false;
            passwordConfirmMessage.style.display = 'block';
            passwordConfirmInput.classList.add('input-error');
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
