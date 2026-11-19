<?php

// Caminho do arquivo JSON
$arquivo = __DIR__ . '/../data/enderecos.json';

// Função para retornar à página de endereços
function redirecionar($status) {
    header("Location: ../index.php?pagina=enderecos&status=" . $status);
    exit;
}

// Verifica se a requisição foi enviada pelo método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('erro');
}

// Recebe os dados do formulário
$acao = $_POST['acao'] ?? '';
$id = $_POST['id'] ?? '';
$cep = trim($_POST['cep'] ?? '');
$rua = trim($_POST['rua'] ?? '');
$numero = trim($_POST['numero'] ?? '');

// Validação dos campos
if (
    empty($cep) ||
    empty($rua) ||
    empty($numero)
) {
    redirecionar('campos_invalidos');
}

// Verifica se o arquivo JSON existe
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, '[]');
}

// Lê os endereços existentes
$conteudo = file_get_contents($arquivo);
$enderecos = json_decode($conteudo, true);

// Verifica se o JSON é válido
if (!is_array($enderecos)) {
    redirecionar('erro');
}

// Cadastro de endereço
if ($acao === 'cadastrar') {

    // Gera um novo ID
    $maiorId = 0;

    foreach ($enderecos as $endereco) {
        $maiorId = max($maiorId, (int) $endereco['id']);
    }

    $novoEndereco = [
        'id' => $maiorId + 1,
        'cep' => $cep,
        'rua' => $rua,
        'numero' => $numero
    ];

    $enderecos[] = $novoEndereco;

    $status = 'cadastrado';

} elseif ($acao === 'editar') {

    $encontrado = false;

    foreach ($enderecos as &$endereco) {

        if ((int) $endereco['id'] === (int) $id) {

            $endereco['cep'] = $cep;
            $endereco['rua'] = $rua;
            $endereco['numero'] = $numero;

            $encontrado = true;
            break;
        }
    }

    unset($endereco);

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
    json_encode($enderecos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
    LOCK_EX
);

if ($resultado === false) {
    redirecionar('erro');
}

// Retorna à página de endereços
redirecionar($status);

?>
```