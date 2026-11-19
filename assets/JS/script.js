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