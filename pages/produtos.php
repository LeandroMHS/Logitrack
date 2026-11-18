<?php

    $arquivo = __DIR__ . '/../data/produtos.json';

    // Verifica se o arquivo JSON existe
    if (file_exists($arquivo)) {

        // Lê o conteúdo do JSON
        $conteudo = file_get_contents($arquivo);
        $produtos = json_decode($conteudo, true);

    } else {
        $produtos = [];
    }

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Produtos</h2>
        <p class="text-muted mb-0">Cadastre e gerencie os produtos disponíveis para transporte.</p>
    </div>

    <button class="btn btn-primary" type="button" id="btnNovoProduto">
        <i class="bi bi-plus-lg me-2"></i>Novo produto
    </button>
</div>

<!-- Formulário de cadastro e edição -->
<div class="card border-0 shadow-sm" id="formularioProduto">
    <div class="card-body">

        <h5 class="fw-bold mb-1" id="tituloFormulario">Cadastrar produto</h5>
        <p class="text-muted small mb-4">Preencha as informações do produto.</p>

        <form action="actions/produto_action.php" method="POST">

            <input type="hidden" name="acao" value="cadastrar" id="acaoProduto">
            <input type="hidden" name="id" id="idProduto">

            <div class="row g-3">

                <div class="col-md-6">
                    <label for="nome" class="form-label fw-semibold">Nome do produto</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        placeholder="Ex: Notebook"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="quantidade" class="form-label fw-semibold">Quantidade disponível</label>
                    <input
                        type="number"
                        class="form-control"
                        id="quantidade"
                        name="quantidade"
                        placeholder="Ex: 50"
                        min="0"
                        required
                    >
                </div>

                <div class="col-12">
                    <label for="descricao" class="form-label fw-semibold">Descrição</label>
                    <textarea
                        class="form-control"
                        id="descricao"
                        name="descricao"
                        rows="3"
                        placeholder="Descreva as características do produto..."
                        required
                    ></textarea>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="reset" class="btn btn-light border" id="btnCancelar">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-primary" id="btnSalvar">
                    <i class="bi bi-check-lg me-2"></i>Salvar produto
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Tabela de produtos -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Produtos cadastrados</h5>
                <p class="text-muted small mb-0">Consulte e edite os produtos disponíveis.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-hover">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Quantidade disponível</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    if (!empty($produtos)) {

                        foreach ($produtos as $produto) {
                    ?>

                            <tr>
                                <td><?= htmlspecialchars($produto['id']) ?></td>
                                <td><?= htmlspecialchars($produto['nome']) ?></td>

                                <td title="<?= htmlspecialchars($produto['descricao']) ?>">
                                    <?= htmlspecialchars(mb_strimwidth($produto['descricao'], 0, 45, '...')) ?>
                                </td>
                                
                                <td><?= htmlspecialchars($produto['quantidade']) ?></td>

                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btnEditar"

                                        data-id="<?= htmlspecialchars($produto['id']) ?>"
                                        data-nome="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-descricao="<?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-quantidade="<?= htmlspecialchars($produto['quantidade']) ?>"
                                    >
                                        <i class="bi bi-pencil-square">Editar</i>
                                    </button>
                                </td>
                            </tr>

                    <?php
                        }

                    } else {
                    ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nenhum produto cadastrado.
                            </td>
                        </tr>

                    <?php
                    }
                    ?>

                </tbody>

            </table>
        </div>

    </div>
</div>