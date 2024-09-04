document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggle-details-btn');
    const searchForm = document.getElementById('searchForm');
    const searchInput = searchForm.querySelector('input[name="search"]');

    // Função para enviar a solicitação de pesquisa
    function fetchVagas(searchKeyword) {
        fetch('paginaPrincipal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                search: searchKeyword,
            }),
        })
        .then(response => response.text())
        .then(data => {
            // Atualiza a seção de vagas com o HTML retornado
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, 'text/html');
            const newVagasSection = doc.querySelector('.vagas-section');

            const vagasSection = document.querySelector('.vagas-section');
            if (newVagasSection && vagasSection) {
                vagasSection.innerHTML = newVagasSection.innerHTML;
            }

            // Reaplicar os eventos dos botões
            const toggleButtons = document.querySelectorAll('.toggle-details-btn');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const vagaCard = button.closest('.vaga-card');
                    const fullDescription = vagaCard.querySelector('.full-description');

                    if (fullDescription.style.display === 'none' || fullDescription.style.display === '') {
                        fullDescription.style.display = 'block';
                        button.textContent = 'Ver Menos';
                    } else {
                        fullDescription.style.display = 'none';
                        button.textContent = 'Ver Mais';
                    }
                });
            });
        })
        .catch(error => console.error('Erro ao buscar vagas:', error));
    }

    // Evento de submit do formulário
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const searchKeyword = searchInput.value.trim();
        fetchVagas(searchKeyword);
    });

    // Evento de input no campo de pesquisa para detectar quando é limpo
    searchInput.addEventListener('input', () => {
        const searchKeyword = searchInput.value.trim();
        if (searchKeyword === '') {
            // Quando a barra de pesquisa está vazia, mostra todas as vagas
            fetchVagas('');
        }
    });

    // Inicialmente carrega todas as vagas
    fetchVagas('');
});
