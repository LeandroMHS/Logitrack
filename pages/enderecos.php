<?php

    $arquivo = __DIR__ . '/../data/enderecos.json';

    // Verifica se o arquivo JSON existe
    if (file_exists($arquivo)) {

        // Lê o conteúdo do JSON
        $conteudo = file_get_contents($arquivo);
        $enderecos = json_decode($conteudo, true);

    } else {
        $enderecos = [];
    }

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Endereços</h2>
        <p class="text-muted mb-0">
            Gerencie os endereços cadastrados no sistema.
        </p>
    </div>
</div>


<!-- Formulário de cadastro e edição -->
<div class="card border-0 shadow-sm mb-4" id="formularioEndereco">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-4" id="tituloFormulario">
            Cadastrar endereço
        </h5>

        <form action="actions/endereco_action.php" method="POST">

            <input type="hidden" name="acao" value="cadastrar" id="acaoEndereco">
            <input type="hidden" name="id" id="idEndereco">

            <div class="row g-3">

                <!-- CEP -->
                <div class="col-md-3">
                    <label for="cepEndereco" class="form-label">
                        CEP
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="cepEndereco"
                        name="cep"
                        placeholder="00000-000"
                        maxlength="9"
                        required
                    >
                </div>

                <!-- Rua -->
                <div class="col-md-6">
                    <label for="ruaEndereco" class="form-label">
                        Rua
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="ruaEndereco"
                        name="rua"
                        placeholder="Digite o nome da rua"
                        required
                    >
                </div>

                <!-- Número -->
                <div class="col-md-3">
                    <label for="numeroEndereco" class="form-label">
                        Número
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="numeroEndereco"
                        name="numero"
                        placeholder="Ex: 123 ou S/N"
                        required
                    >
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">

                <button
                    type="reset"
                    class="btn btn-outline-secondary"
                    id="btnCancelarEndereco"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="btnSalvarEndereco"
                >
                    <i class="bi bi-check-lg me-2"></i>
                    Salvar endereço
                </button>

            </div>

        </form>

    </div>
</div>


<!-- Tabela de endereços -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Endereços cadastrados</h5>
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>CEP</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    if (!empty($enderecos)) {

                        foreach ($enderecos as $endereco) {
                    ?>

                            <tr>
                                <td><?= htmlspecialchars($endereco['id']) ?></td>
                                <td><?= htmlspecialchars($endereco['cep']) ?></td>
                                <td><?= htmlspecialchars($endereco['rua']) ?></td>
                                <td><?= htmlspecialchars($endereco['numero']) ?></td>

                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btnEditarEndereco"

                                        data-id="<?= htmlspecialchars($endereco['id']) ?>"
                                        data-cep="<?= htmlspecialchars($endereco['cep'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-rua="<?= htmlspecialchars($endereco['rua'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-numero="<?= htmlspecialchars($endereco['numero'], ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        Editar
                                    </button>
                                </td>
                            </tr>

                    <?php
                        }

                    } else {
                    ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nenhum endereço cadastrado.
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
```