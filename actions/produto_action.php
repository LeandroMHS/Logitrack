<?php

// Caminho do arquivo JSON
$arquivo = __DIR__ . '/../data/produtos.json';

// Função para retornar à página de produtos
function redirecionar($status) {
    header("Location: ../index.php?pagina=produtos&status=" . $status);
    exit;
}

// Verifica se a requisição foi enviada pelo método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('erro');
}

// Recebe os dados do formulário
$acao = $_POST['acao'] ?? '';
$id = $_POST['id'] ?? '';
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$quantidade = filter_var($_POST['quantidade'] ?? null, FILTER_VALIDATE_INT);

// Validação dos campos
if (
    empty($nome) ||
    empty($descricao) ||
    $quantidade === false ||
    $quantidade === null ||
    $quantidade < 0
) {
    redirecionar('campos_invalidos');
}

// Verifica se o arquivo JSON existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, '[]');
}

// Lê os produtos existentes
$conteudo = file_get_contents($arquivo);
$produtos = json_decode($conteudo, true);

// Verifica se o JSON é válido
if (!is_array($produtos)) {
    redirecionar('erro');
}

// Cadastro de produto
if ($acao === 'cadastrar') {

    // Gera um novo ID
    $maiorId = 0;

    foreach ($produtos as $produto) {
        $maiorId = max($maiorId, (int) $produto['id']);
    }

    $novoProduto = [
        'id' => $maiorId + 1,
        'nome' => $nome,
        'descricao' => $descricao,
        'quantidade' => $quantidade
    ];

    $produtos[] = $novoProduto;

    $status = 'cadastrado';

// Edição de produto
} elseif ($acao === 'editar') {

    $encontrado = false;

    foreach ($produtos as &$produto) {

        if ((int) $produto['id'] === (int) $id) {

            $produto['nome'] = $nome;
            $produto['descricao'] = $descricao;
            $produto['quantidade'] = $quantidade;

            $encontrado = true;
            break;
        }
    }

    unset($produto);

    if (!$encontrado) {
        redirecionar('nao_encontrado');
    }

    $status = 'atualizado';

} else {
    redirecionar('erro');
}

// Salva os dados no JSON
$resultado = file_put_contents(
    $arquivo,
    json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
);

if ($resultado === false) {
    redirecionar('erro');
}

// Retorna à página de produtos
redirecionar($status);

?>