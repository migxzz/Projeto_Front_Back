document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('vagaForm');

    form.addEventListener('submit', function(event) {
        const titulo = document.getElementById('titulo').value.trim();
        const descricao = document.getElementById('descricao').value.trim();

        if (titulo.length < 5) {
            alert('O título deve ter pelo menos 5 caracteres.');
            event.preventDefault(); // Impede o envio do formulário
            return;
        }

        if (descricao.length < 20) {
            alert('A descrição deve ter pelo menos 20 caracteres.');
            event.preventDefault(); // Impede o envio do formulário
            return;
        }
    });
});
