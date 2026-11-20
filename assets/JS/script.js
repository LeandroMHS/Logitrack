//---------------------FUNÇÕES DE EDIÇÕES DOS PRODUTOS---------------------
function editarProduto(botao) {

    // Recupera os dados do produto
    const id = botao.dataset.id;
    const nome = botao.dataset.nome;
    const descricao = botao.dataset.descricao;
    const quantidade = botao.dataset.quantidade;

    // Preenche os campos do formulário
    document.getElementById('idProduto').value = id;
    document.getElementById('nomeProduto').value = nome;
    document.getElementById('descricaoProduto').value = descricao;
    document.getElementById('quantidadeProduto').value = quantidade;

    // Altera a operação para edição
    document.getElementById('acaoProduto').value = 'editar';

    // Atualiza os textos do formulário
    document.getElementById('tituloFormulario').textContent = 'Editar produto';

    document.getElementById('btnSalvarProduto').innerHTML =
        '<i class="bi bi-check-lg me-2"></i>Atualizar produto';

    // Rola a página para o formulário
    document.getElementById('formularioProduto').scrollIntoView({
        behavior: 'smooth'
    });
}

function cancelarEdicaoProduto() {

    // Limpa os campos do formulário
    document.querySelector('#formularioProduto form').reset();

    // Limpa o ID do produto selecionado
    document.getElementById('idProduto').value = '';

    // Retorna a operação para cadastro
    document.getElementById('acaoProduto').value = 'cadastrar';

    // Restaura o título
    document.getElementById('tituloFormulario').textContent = 'Cadastrar produto';

    // Restaura o texto do botão
    document.getElementById('btnSalvarProduto').innerHTML =
        '<i class="bi bi-check-lg me-2"></i>Salvar produto';
}

//---------------------FUNÇÕES PARA EDIÇÃO DE TRANSPORTADORES---------------------
function editarTransportador(botao){

    // Recupera os dados do produto
    const id = botao.dataset.id;
    const nome = botao.dataset.nome;
    const documento = botao.dataset.documento;
    const telefone = botao.dataset.telefone;

    // Preenche os campos do formulário
    document.getElementById('idTransportador').value = id;
    document.getElementById('nomeTransportador').value = nome;
    document.getElementById('documentoTransportador').value = documento;
    document.getElementById('telefoneTransportador').value = telefone;

    // Altera a operação para edição
    document.getElementById('acaoTransportador').value = 'editar';

    // Atualiza os textos do formulário
    document.getElementById('tituloFormulario').textContent = 'Editar Transportador';

    document.getElementById('btnSalvarTransportador').innerHTML =
        '<i class="bi bi-check-lg me-2"></i>Atualizar transportador';

    // Rola a página para o formulário
    document.getElementById('formularioTransportador').scrollIntoView({
        behavior: 'smooth'
    });
}

function cancelarEdicaoTransportador(){
     // Limpa os campos do formulário
    document.querySelector('#formularioTransportador form').reset();

    // Limpa o ID do produto selecionado
    document.getElementById('idTransportador').value = '';

    // Retorna a operação para cadastro
    document.getElementById('acaoTransportador').value = 'cadastrar';

    // Restaura o título
    document.getElementById('tituloFormulario').textContent = 'Cadastrar Transportador';

    // Restaura o texto do botão
    document.getElementById('btnSalvarTransportador').innerHTML =
        '<i class="bi bi-check-lg me-2"></i>Salvar Transportador';
}

//---------------------FUNÇÕES PARA EDIÇÃO DE ENDEREÇOS---------------------//
function abrirFormularioFrete() {

    const formulario = document.getElementById('formularioFrete');

    // Exibe o formulário
    formulario.style.display = 'block';

    // Rola a página até o formulário
    formulario.scrollIntoView({
        behavior: 'smooth'
    });
}


function editarEndereco(botao) {

    // Recupera os dados do endereço
    const id = botao.dataset.id;
    const cep = botao.dataset.cep;
    const rua = botao.dataset.rua;
    const numero = botao.dataset.numero;

    // Preenche os campos do formulário
    document.getElementById('idEndereco').value = id;
    document.getElementById('cepEndereco').value = cep;
    document.getElementById('ruaEndereco').value = rua;
    document.getElementById('numeroEndereco').value = numero;

    // Altera a operação para edição
    document.getElementById('acaoEndereco').value = 'editar';

    // Atualiza os textos do formulário
    document.getElementById('tituloFormulario').textContent = 'Editar endereço';

    document.getElementById('btnSalvarEndereco').innerHTML =
        '<i class="bi bi-check-lg me-2"></i>Atualizar endereço';

    // Rola a página para o formulário
    document.getElementById('formularioEndereco').scrollIntoView({
        behavior: 'smooth'
    });
}

// Botões de edição dos produtos
const botoesEditarProduto = document.querySelectorAll('.btnEditarProduto');
const btnCancelarProduto = document.getElementById('btnCancelarProduto');

if (btnCancelarProduto) {
    btnCancelarProduto.addEventListener('click', function() {
        cancelarEdicaoProduto();
    });
}

botoesEditarProduto.forEach(function(botao) {
    botao.addEventListener('click', function() {
        editarProduto(botao);
    });
});

// Botão de edição dos transportadores
const botoesEditartransportador = document.querySelectorAll('.btnEditarTransportador');
const btnCancelarTransportador = document.getElementById('btnCancelarTransportador');

botoesEditartransportador.forEach(function(botao) {
    botao.addEventListener('click', function() {
        editarTransportador(botao);
    });
});

if (btnCancelarTransportador) {
    btnCancelarTransportador.addEventListener('click', function() {
        cancelarEdicaoTransportador();
    });
}

// Botões de edição dos endereços
const botoesEditarEndereco = document.querySelectorAll('.btnEditarEndereco');

const btnCancelarEndereco = document.getElementById('btnCancelarEndereco');

botoesEditarEndereco.forEach(function(botao) {
    botao.addEventListener('click', function() {
        editarEndereco(botao);
    });
});

// Botão de cancelar edição
if (btnCancelarEndereco) {
    btnCancelarEndereco.addEventListener('click', function() {
        cancelarEdicaoEndereco();
    });
}

//---------------------FUNÇÕES PARA GERAÇÃO DE FRETES---------------------//

// Adiciona um novo produto ao formulário
function adicionarProdutoFrete() {

    const listaProdutos = document.getElementById('listaProdutosFrete');

    // Recupera todas as linhas existentes
    const produtos = listaProdutos.querySelectorAll('.itemProdutoFrete');

    // Verifica se todas as linhas estão preenchidas
    for (const produto of produtos) {

        const select = produto.querySelector('select');
        const quantidade = produto.querySelector('input');

        if (select.value === '' || quantidade.value === '') {

            alert('Preencha o produto e a quantidade antes de adicionar outro.');

            return;
        }
    }

    // Recupera a primeira linha como modelo
    const primeiroProduto = listaProdutos.querySelector('.itemProdutoFrete');

    // Cria uma cópia da linha
    const novoProduto = primeiroProduto.cloneNode(true);

    // Limpa os campos da nova linha
    novoProduto.querySelector('select').selectedIndex = 0;
    novoProduto.querySelector('input').value = '';

    // Habilita o botão de remover
    novoProduto.querySelector('.btnRemoverProdutoFrete').disabled = false;

    // Adiciona a nova linha
    listaProdutos.appendChild(novoProduto);

    // Atualiza os índices dos campos
    atualizarIndicesProdutos();
}


// Remove uma linha de produto
function removerProdutoFrete(botao) {

    const listaProdutos = document.getElementById('listaProdutosFrete');

    // Recupera todas as linhas existentes
    const produtos = listaProdutos.querySelectorAll('.itemProdutoFrete');

    // Verifica se existe mais de uma linha
    if (produtos.length > 1) {

        // Identifica e remove a linha correspondente ao botão
        botao.closest('.itemProdutoFrete').remove();

        // Atualiza os índices dos campos
        atualizarIndicesProdutos();
    }
}


// Atualiza os índices dos produtos
function atualizarIndicesProdutos() {

    const produtos = document.querySelectorAll('.itemProdutoFrete');

    produtos.forEach(function(produto, indice) {

        // Atualiza o campo de seleção
        produto.querySelector('select').name =
            `produtos[${indice}][produto_id]`;

        // Atualiza o campo de quantidade
        produto.querySelector('input').name =
            `produtos[${indice}][quantidade]`;

        // Controla o botão de remover
        const btnRemover = produto.querySelector('.btnRemoverProdutoFrete');

        // Impede remover a última linha
        btnRemover.disabled = produtos.length === 1;

    });
}

// Cancela a geração do frete
function cancelarFrete() {

    const formulario = document.getElementById('formFrete');
    const listaProdutos = document.getElementById('listaProdutosFrete');

    // Limpa todos os campos do formulário
    formulario.reset();

    // Recupera todas as linhas de produtos
    const produtos = listaProdutos.querySelectorAll('.itemProdutoFrete');

    // Mantém somente a primeira linha
    produtos.forEach(function(produto, indice) {

        if (indice > 0) {
            produto.remove();
        }

    });

    // Limpa os campos da primeira linha
    const primeiroProduto = listaProdutos.querySelector('.itemProdutoFrete');

    primeiroProduto.querySelector('select').selectedIndex = 0;
    primeiroProduto.querySelector('input').value = '';

    // Atualiza os índices e os botões
    atualizarIndicesProdutos();

    // Oculta o formulário
    document.getElementById('formularioFrete').style.display = 'none';
}


// Botão para adicionar produtos
const btnAdicionarProdutoFrete = document.getElementById('btnAdicionarProdutoFrete');

if (btnAdicionarProdutoFrete) {

    btnAdicionarProdutoFrete.addEventListener('click', function() {
        adicionarProdutoFrete();
    });
}

// Botão para abrir o formulário
const btnNovoFrete = document.getElementById('btnNovoFrete');

if (btnNovoFrete) {
    btnNovoFrete.addEventListener('click', function() {
        abrirFormularioFrete();
    });
}

// Botão para cancelar a geração do frete
const btnCancelarFrete = document.getElementById('btnCancelarFrete');

if (btnCancelarFrete) {

    btnCancelarFrete.addEventListener('click', function() {
        cancelarFrete();
    });

}

// Botões para remover produtos
document.addEventListener('click', function(event) {

    const btnRemover = event.target.closest('.btnRemoverProdutoFrete');

    if (btnRemover) {
        removerProdutoFrete(btnRemover);
    }

});