<?php

// Caminhos dos arquivos JSON
$caminhoProdutos = __DIR__ . '/../data/produtos.json';
$caminhoTransportadores = __DIR__ . '/../data/transportadores.json';
$caminhoEnderecos = __DIR__ . '/../data/enderecos.json';
$caminhoFretes = __DIR__ . '/../data/fretes.json';


// Função para redirecionar com uma mensagem
function redirecionar($status) {
    header("Location: ../index.php?pagina=fretes&status=" . urlencode($status));
    exit;
}


// Função para carregar os dados JSON
function carregarJson($caminho) {

    if (!file_exists($caminho)) {
        return false;
    }

    $conteudo = file_get_contents($caminho);
    $dados = json_decode($conteudo, true);

    if (!is_array($dados)) {
        return false;
    }

    return $dados;
}


// Função para salvar os dados JSON
function salvarJson($caminho, $dados) {

    $json = json_encode(
        $dados,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

    if ($json === false) {
        return false;
    }

    // Cria um arquivo temporário no mesmo diretório
    $temporario = tempnam(dirname($caminho), 'json_');

    if ($temporario === false) {
        return false;
    }

    // Escreve os dados no arquivo temporário
    if (file_put_contents($temporario, $json) === false) {
        unlink($temporario);
        return false;
    }

    // Substitui o arquivo original
    if (!rename($temporario, $caminho)) {
        unlink($temporario);
        return false;
    }

    return true;
}


// Verifica se a requisição foi enviada por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar('erro');
}


// Recupera a ação solicitada
$acao = $_POST['acao'] ?? '';


// Carrega os arquivos JSON
$produtos = carregarJson($caminhoProdutos);
$transportadores = carregarJson($caminhoTransportadores);
$enderecos = carregarJson($caminhoEnderecos);
$fretes = carregarJson($caminhoFretes);


// Verifica se os arquivos foram carregados corretamente
if (
    $produtos === false ||
    $transportadores === false ||
    $enderecos === false ||
    $fretes === false
) {
    redirecionar('erro_arquivos');
}


// ======================================================
// CADASTRO DE FRETE
// ======================================================

if ($acao === 'cadastrar') {

    // Recupera os dados enviados pelo formulário
    $transportadorId = $_POST['transportador_id'] ?? '';
    $origemId = $_POST['origem_id'] ?? '';
    $destinoId = $_POST['destino_id'] ?? '';
    $data = $_POST['data'] ?? '';
    $produtosFrete = $_POST['produtos'] ?? [];


    // Validação dos campos obrigatórios
    if (
        $transportadorId === '' ||
        $origemId === '' ||
        $destinoId === '' ||
        $data === '' ||
        !is_array($produtosFrete) ||
        empty($produtosFrete)
    ) {
        redirecionar('dados_invalidos');
    }


    // Valida o formato da data
    $dataValidada = DateTime::createFromFormat('!Y-m-d', $data);

    if (
        !$dataValidada ||
        $dataValidada->format('Y-m-d') !== $data
    ) {
        redirecionar('dados_invalidos');
    }


    // Verifica se o transportador existe
    $transportadorEncontrado = false;

    foreach ($transportadores as $transportador) {

        if ((string) $transportador['id'] === (string) $transportadorId) {
            $transportadorEncontrado = true;
            break;
        }
    }

    if (!$transportadorEncontrado) {
        redirecionar('transportador_invalido');
    }


    // Verifica se os endereços existem
    $origemEncontrada = false;
    $destinoEncontrado = false;

    foreach ($enderecos as $endereco) {

        if ((string) $endereco['id'] === (string) $origemId) {
            $origemEncontrada = true;
        }

        if ((string) $endereco['id'] === (string) $destinoId) {
            $destinoEncontrado = true;
        }
    }

    if (!$origemEncontrada || !$destinoEncontrado) {
        redirecionar('endereco_invalido');
    }


    // Organiza os produtos e suas quantidades
    $produtosSelecionados = [];

    foreach ($produtosFrete as $item) {

        $produtoId = $item['produto_id'] ?? '';
        $quantidade = $item['quantidade'] ?? '';

        // Verifica se os valores são válidos
        if (
            $produtoId === '' ||
            filter_var($quantidade, FILTER_VALIDATE_INT) === false ||
            (int) $quantidade <= 0
        ) {
            redirecionar('produtos_invalidos');
        }

        // Soma quantidades caso o mesmo produto apareça mais de uma vez
        if (!isset($produtosSelecionados[$produtoId])) {
            $produtosSelecionados[$produtoId] = 0;
        }

        $produtosSelecionados[$produtoId] += (int) $quantidade;
    }


    // Guarda os dados dos produtos que serão registrados no frete
    $itensFrete = [];


    // Guarda os novos estoques sem alterar os dados originais ainda
    $novosEstoques = [];


    // Valida todos os produtos e seus estoques
    foreach ($produtosSelecionados as $produtoId => $quantidade) {

        $produtoEncontrado = false;

        foreach ($produtos as $indice => $produto) {

            if ((string) $produto['id'] === (string) $produtoId) {

                $produtoEncontrado = true;

                $estoqueAtual = (int) $produto['quantidade'];

                // Verifica se existe estoque suficiente
                if ($quantidade > $estoqueAtual) {
                    redirecionar('estoque_insuficiente');
                }

                // Calcula o novo estoque
                $novosEstoques[$indice] = $estoqueAtual - $quantidade;

                // Adiciona o produto ao frete
                $itensFrete[] = [
                    'produto_id' => (int) $produtoId,
                    'quantidade' => $quantidade
                ];

                break;
            }
        }

        if (!$produtoEncontrado) {
            redirecionar('produto_invalido');
        }
    }


    // Atualiza os estoques somente depois de todas as validações
    foreach ($novosEstoques as $indice => $novoEstoque) {
        $produtos[$indice]['quantidade'] = $novoEstoque;
    }


    // Gera o próximo ID do frete
    $idsFretes = array_column($fretes, 'id');

    $novoId = empty($idsFretes) ? 1 : max($idsFretes) + 1;


    // Monta o registro do frete
    $novoFrete = [
        'id' => $novoId,
        'transportador_id' => (int) $transportadorId,
        'origem_id' => (int) $origemId,
        'destino_id' => (int) $destinoId,
        'data' => $data,
        'produtos' => $itensFrete
    ];


    // Guarda o conteúdo original dos produtos para possível recuperação
    $conteudoOriginalProdutos = file_get_contents($caminhoProdutos);


    // Adiciona o novo frete à lista
    $fretes[] = $novoFrete;


    // Salva primeiro o estoque atualizado
    if (!salvarJson($caminhoProdutos, $produtos)) {
        redirecionar('erro_salvar');
    }


    // Salva o novo frete
    if (!salvarJson($caminhoFretes, $fretes)) {

        // Tenta restaurar o estoque original caso o frete não seja salvo
        if ($conteudoOriginalProdutos !== false) {
            file_put_contents(
                $caminhoProdutos,
                $conteudoOriginalProdutos,
                LOCK_EX
            );
        }

        redirecionar('erro_salvar');
    }


    // Finaliza o cadastro
    redirecionar('sucesso');

}


// ======================================================
// GERAÇÃO DO RELATÓRIO DIÁRIO
// ======================================================

if ($acao === 'relatorio') {

    $dataRelatorio = $_POST['data_relatorio'] ?? '';


    // Valida a data recebida
    $dataValidada = DateTime::createFromFormat('!Y-m-d', $dataRelatorio);

    if (
        !$dataValidada ||
        $dataValidada->format('Y-m-d') !== $dataRelatorio
    ) {
        redirecionar('data_relatorio_invalida');
    }


    // Localiza os fretes da data selecionada
    $fretesDoDia = [];

    foreach ($fretes as $frete) {

        if ($frete['data'] === $dataRelatorio) {
            $fretesDoDia[] = $frete;
        }
    }


    // Prepara o arquivo CSV
    $nomeArquivo = 'relatorio_fretes_' . $dataRelatorio . '.csv';

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');


    $arquivo = fopen('php://output', 'w');

    // BOM para facilitar a leitura de caracteres especiais no Excel
    fwrite($arquivo, "\xEF\xBB\xBF");


    // Cabeçalho do relatório
    fputcsv($arquivo, [
        'Código do frete',
        'Data',
        'Transportador',
        'Origem',
        'Destino',
        'Produto',
        'Quantidade'
    ], ';');


    // Percorre os fretes encontrados
    foreach ($fretesDoDia as $frete) {

        // Localiza o transportador
        $nomeTransportador = 'Não encontrado';

        foreach ($transportadores as $transportador) {

            if ((string) $transportador['id'] === (string) $frete['transportador_id']) {
                $nomeTransportador = $transportador['nome'];
                break;
            }
        }


        // Localiza os endereços
        $origem = 'Não encontrada';
        $destino = 'Não encontrado';

        foreach ($enderecos as $endereco) {

            if ((string) $endereco['id'] === (string) $frete['origem_id']) {
                $origem = $endereco['rua'] . ', ' . $endereco['numero'];
            }

            if ((string) $endereco['id'] === (string) $frete['destino_id']) {
                $destino = $endereco['rua'] . ', ' . $endereco['numero'];
            }
        }


        // Percorre os produtos do frete
        foreach ($frete['produtos'] as $item) {

            $nomeProduto = 'Não encontrado';

            foreach ($produtos as $produto) {

                if ((string) $produto['id'] === (string) $item['produto_id']) {
                    $nomeProduto = $produto['nome'];
                    break;
                }
            }


            // Escreve uma linha para cada produto
            fputcsv($arquivo, [
                $frete['id'],
                date('d/m/Y', strtotime($frete['data'])),
                $nomeTransportador,
                $origem,
                $destino,
                $nomeProduto,
                $item['quantidade']
            ], ';');
        }
    }


    fclose($arquivo);
    exit;
}


// Caso a ação recebida não seja reconhecida
redirecionar('acao_invalida');

?>