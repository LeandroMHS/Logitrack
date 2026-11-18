function editarProduto(botao) {
    // Recupera os dados do produto
    const id = botao.dataset.id;
    const nome = botao.dataset.nome;
    const descricao = botao.dataset.descricao;
    const quantidade = botao.dataset.quantidade;

    // Preenche os campos do formulário
    document.getElementById('idProduto').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('descricao').value = descricao;
    document.getElementById('quantidade').value = quantidade;

    // Altera a operação para edição
    document.getElementById('acaoProduto').value = 'editar';

    // Atualiza os textos do formulário
    document.getElementById('tituloFormulario').textContent = 'Editar produto';

    document.getElementById('btnSalvar').innerHTML =
        '<i class="bi bi-check-lg me-2"></i>Atualizar produto';

    // Rola a página para o formulário
    document.getElementById('formularioProduto').scrollIntoView({
        behavior: 'smooth'
    });
}

// Botão de edição dos produtos
const botoesEditar = document.querySelectorAll('.btnEditar');

botoesEditar.forEach(function(botao) {

    botao.addEventListener('click', function() {
        editarProduto(botao);
    });

});