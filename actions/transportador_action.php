<?php

// Caminho do arquivo JSON
$arquivo = __DIR__ . '/../data/transportadores.json';

// Função para retornar à página de transportadores
function redirecionar($status) {
    header("Location: ../index.php?pagina=transportadores&status=" . $status);
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
$documento = trim($_POST['documento'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');

// Validação dos campos
if (
    empty($nome) ||
    empty($documento) ||
    empty($telefone)
) {
    redirecionar('campos_invalidos');
}

// Verifica se o arquivo JSON existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, '[]');
}

// Lê os transportadores existentes
$conteudo = file_get_contents($arquivo);
$transportadores = json_decode($conteudo, true);

// Verifica se o JSON é válido
if (!is_array($transportadores)) {
    redirecionar('erro');
}

// Cadastro de transportador
if ($acao === 'cadastrar') {

    // Gera um novo ID
    $maiorId = 0;

    foreach ($transportadores as $transportador) {
        $maiorId = max($maiorId, (int) $transportador['id']);
    }

    $novoTransportador = [
        'id' => $maiorId + 1,
        'nome' => $nome,
        'documento' => $documento,
        'telefone' => $telefone
    ];

    $transportadores[] = $novoTransportador;

    $status = 'cadastrado';

} elseif ($acao === 'editar'){
    $encontrado = false;

    foreach ($transportadores as &$transportador) {

        if ((int) $transportador['id'] === (int) $id) {

            $transportador['nome'] = $nome;
            $transportador['documento'] = $documento;
            $transportador['telefone'] = $telefone;

            $encontrado = true;
            break;
        }
    }

    unset($transportador);

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
    json_encode($transportadores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
);

if ($resultado === false) {
    redirecionar('erro');
}

// Retorna à página de transportadores
redirecionar($status);

?>