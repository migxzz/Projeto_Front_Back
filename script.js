document.getElementById('formVaga').addEventListener('submit', function(e) {
  e.preventDefault();

  // Capturar os valores dos campos
  let tituloVaga = document.getElementById('tituloVaga').value;
  let empresaVaga = document.getElementById('empresaVaga').value;
  let localizacaoVaga = document.getElementById('localizacaoVaga').value;
  let descricaoVaga = document.getElementById('descricaoVaga').value;

  // Criar o HTML para a nova vaga
  let novaVaga = `
      <div class="vaga-card">
          <h3>${tituloVaga}</h3>
          <p>${empresaVaga}</p>
          <p>${localizacaoVaga}</p>
          <p>${descricaoVaga}</p>
          <button class="ver-detalhes">Ver detalhes</button>
      </div>
  `;

  // Inserir a nova vaga no topo da lista
  document.getElementById('vagaLista').insertAdjacentHTML('afterbegin', novaVaga);

  // Limpar o formulário
  document.getElementById('formVaga').reset();
});
