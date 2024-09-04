document.addEventListener('DOMContentLoaded', () => {
    const emailInput = document.getElementById('email');
    const loginForm = document.getElementById('login-form');

    // Recupera o e-mail do armazenamento local se existir
    if (localStorage.getItem('savedEmail')) {
        emailInput.value = localStorage.getItem('savedEmail');
    }

    // Salva o e-mail no armazenamento local quando o formulário é enviado
    loginForm.addEventListener('submit', () => {
        const email = emailInput.value;
        if (email) {
            localStorage.setItem('savedEmail', email);
        }
    });
});
