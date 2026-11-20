<?php

// Arquivos JSON
$produtos = json_decode(file_get_contents(__DIR__ . '/../data/produtos.json'), true) ?? [];
$transportadores = json_decode(file_get_contents(__DIR__ . '/../data/transportadores.json'), true) ?? [];
$enderecos = json_decode(file_get_contents(__DIR__ . '/../data/enderecos.json'), true) ?? [];
$fretes = json_decode(file_get_contents(__DIR__ . '/../data/fretes.json'), true) ?? [];

?>

<!-- Cabeçalho -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Fretes</h2>
        <p class="text-muted mb-0">Gerencie e consulte os fretes realizados.</p>
    </div>

    <button class="btn btn-primary" id="btnNovoFrete">
        <i class="bi bi-plus-lg me-2"></i>
        Gerar frete
    </button>
</div>

<!-- Formulário de geração de frete -->
<div class="card border-0 shadow-sm mb-4" id="formularioFrete" style="display: none;">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-4" id="tituloFormularioFrete">
            Gerar novo frete
        </h5>

        <form action="actions/frete_action.php" method="POST" id="formFrete">

            <input type="hidden" name="acao" value="cadastrar">

            <!-- Transportador -->
            <div class="mb-3">
                <label for="transportadorFrete" class="form-label">
                    Transportador
                </label>

                <select class="form-select" id="transportadorFrete" name="transportador_id" required>
                    <option value="">Selecione um transportador</option>

                    <?php foreach ($transportadores as $transportador) { ?>
                        <option value="<?= htmlspecialchars($transportador['id']) ?>">
                            <?= htmlspecialchars($transportador['nome']) ?>
                        </option>
                    <?php } ?>

                </select>
            </div>

            <!-- Endereços -->
            <div class="row g-3 mb-3">

                <div class="col-md-6">
                    <label for="origemFrete" class="form-label">
                        Endereço de origem
                    </label>

                    <select class="form-select" id="origemFrete" name="origem_id" required>
                        <option value="">Selecione o endereço de origem</option>

                        <?php foreach ($enderecos as $endereco) { ?>
                            <option value="<?= htmlspecialchars($endereco['id']) ?>">
                                <?= htmlspecialchars($endereco['rua']) ?>, 
                                <?= htmlspecialchars($endereco['numero']) ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <div class="col-md-6">
                    <label for="destinoFrete" class="form-label">
                        Endereço de destino
                    </label>

                    <select class="form-select" id="destinoFrete" name="destino_id" required>
                        <option value="">Selecione o endereço de destino</option>

                        <?php foreach ($enderecos as $endereco) { ?>
                            <option value="<?= htmlspecialchars($endereco['id']) ?>">
                                <?= htmlspecialchars($endereco['rua']) ?>, 
                                <?= htmlspecialchars($endereco['numero']) ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

            </div>

            <!-- Produtos -->
            <div class="mb-3">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label fw-semibold mb-0">
                        Produtos transportados
                    </label>

                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnAdicionarProdutoFrete">
                        <i class="bi bi-plus-lg me-1"></i>
                        Adicionar produto
                    </button>
                </div>

                <div id="listaProdutosFrete">

                    <!-- Primeira linha de produto -->
                    <div class="row g-2 mb-2 itemProdutoFrete">

                        <div class="col-md-8">
                            <select class="form-select selectProdutoFrete" name="produtos[0][produto_id]" required>
                                <option value="">Selecione um produto</option>

                                <?php foreach ($produtos as $produto) { ?>
                                    <option
                                        value="<?= htmlspecialchars($produto['id']) ?>"
                                        data-estoque="<?= htmlspecialchars($produto['quantidade']) ?>">

                                        <?= htmlspecialchars($produto['nome']) ?>
                                        (Estoque: <?= htmlspecialchars($produto['quantidade']) ?>)

                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="col-md-3">
                            <input
                                type="number"
                                class="form-control"
                                name="produtos[0][quantidade]"
                                placeholder="Quantidade"
                                min="1"
                                required>
                        </div>

                        <div class="col-md-1">
                            <!--Botão para remover produto do frete-->
                            <button type="button" class="btn btn-outline-danger w-100 btnRemoverProdutoFrete" disabled>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Data do frete -->
            <div class="mb-3">
                <label for="dataFrete" class="form-label">
                    Data de realização
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="dataFrete"
                    name="data"
                    value="<?= date('Y-m-d') ?>"
                    required>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-end gap-2 mt-4">

                <button type="reset" class="btn btn-outline-secondary" id="btnCancelarFrete">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i>
                    Concluir frete
                </button>

            </div>

        </form>
    </div>
</div>

<!-- Listagem de fretes -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">Fretes realizados</h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Transportador</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Data</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($fretes)) { ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nenhum frete realizado até o momento.
                            </td>
                        </tr>

                    <?php } else { ?>

                        <?php foreach ($fretes as $frete) { ?>

                            <?php
                            $nomeTransportador = 'Não encontrado';
                            $ruaOrigem = 'Não encontrada';
                            $ruaDestino = 'Não encontrado';

                            foreach ($transportadores as $transportador) {
                                if ($transportador['id'] == $frete['transportador_id']) {
                                    $nomeTransportador = $transportador['nome'];
                                    break;
                                }
                            }

                            foreach ($enderecos as $endereco) {
                                if ($endereco['id'] == $frete['origem_id']) {
                                    $ruaOrigem = $endereco['rua'] . ', ' . $endereco['numero'];
                                }

                                if ($endereco['id'] == $frete['destino_id']) {
                                    $ruaDestino = $endereco['rua'] . ', ' . $endereco['numero'];
                                }
                            }
                            ?>

                            <tr>
                                <td>#<?= htmlspecialchars($frete['id']) ?></td>

                                <td><?= htmlspecialchars($nomeTransportador) ?></td>

                                <td><?= htmlspecialchars($ruaOrigem) ?></td>

                                <td><?= htmlspecialchars($ruaDestino) ?></td>

                                <td>
                                    <?= date('d/m/Y', strtotime($frete['data'])) ?>
                                </td>
                            </tr>

                        <?php } ?>

                    <?php } ?>

                </tbody>

            </table>

        </div>
    </div>
</div>

<!-- Relatório diário -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-file-earmark-spreadsheet fs-3 text-primary me-3"></i>

            <div>
                <h5 class="fw-bold mb-1">Relatório diário de fretes</h5>
                <p class="text-muted mb-0">
                    Gere um relatório com todos os fretes realizados em uma data específica.
                </p>
            </div>
        </div>

        <form action="actions/frete_action.php" method="POST" class="row g-3 align-items-end">

            <input type="hidden" name="acao" value="relatorio">

            <div class="col-md-6">
                <label for="dataRelatorio" class="form-label">
                    Data dos fretes
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="dataRelatorio"
                    name="data_relatorio"
                    value="<?= date('Y-m-d') ?>"
                    required>
            </div>

            <div class="col-md-6">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i>
                    Gerar e baixar relatório
                </button>
            </div>

        </form>

    </div>
</div>