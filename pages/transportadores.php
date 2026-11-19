<?php

    $arquivo = __DIR__ . '/../data/transportadores.json';

    // Verifica se o arquivo JSON existe
    if (file_exists($arquivo)) {

        // Lê o conteúdo do JSON
        $conteudo = file_get_contents($arquivo);
        $transportadores = json_decode($conteudo, true);

    } else {
        $transportadores = [];
    }

?>


<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Transportadores</h2>
        <p class="text-muted mb-0">
            Gerencie os transportadores cadastrados no sistema.
        </p>
    </div>
</div>


<!-- Formulário de cadastro e edição -->
<div class="card border-0 shadow-sm mb-4" id="formularioTransportador">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-4" id="tituloFormulario">
            Cadastrar transportador
        </h5>

        <form action="actions/transportador_action.php" method="POST">

            <input type="hidden" name="acao" value="cadastrar" id="acaoTransportador">
            <input type="hidden" name="id" id="idTransportador">

            <div class="row g-3">

                <!-- Nome -->
                <div class="col-md-6">
                    <label for="nomeTransportador" class="form-label">
                        Nome
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nomeTransportador"
                        name="nome"
                        placeholder="Digite o nome do transportador"
                        required
                    >
                </div>

                <!-- CPF/CNPJ -->
                <div class="col-md-3">
                    <label for="documentoTransportador" class="form-label">
                        CPF/CNPJ
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="documentoTransportador"
                        name="documento"
                        placeholder="Digite o documento"
                        maxlength="18"
                        required
                    >
                </div>

                <!-- Telefone -->
                <div class="col-md-3">
                    <label for="telefoneTransportador" class="form-label">
                        Telefone
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="telefoneTransportador"
                        name="telefone"
                        placeholder="(00) 00000-0000"
                        maxlength="15"
                        required
                    >
                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">

                <button
                    type="reset"
                    class="btn btn-outline-secondary"
                    id="btnCancelarTransportador"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="btnSalvarTransportador"
                >
                    <i class="bi bi-check-lg me-2"></i>
                    Salvar transportador
                </button>

            </div>

        </form>

    </div>
</div>


<!-- Tabela de transportadores -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Transportadores cadastrados</h5>
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    if (!empty($transportadores)) {

                        foreach ($transportadores as $transportador) {
                    ?>

                            <tr>
                                <td><?= htmlspecialchars($transportador['id']) ?></td>
                                <td><?= htmlspecialchars($transportador['nome']) ?></td>
                                <td><?= htmlspecialchars($transportador['documento']) ?></td>
                                <td><?= htmlspecialchars($transportador['telefone']) ?></td>

                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary btnEditarTransportador"

                                        data-id="<?= htmlspecialchars($transportador['id']) ?>"
                                        data-nome="<?= htmlspecialchars($transportador['nome'], ENT_QUOTES, 'UTF-8') ?>"
                                        data-documento="<?= htmlspecialchars($transportador['documento']) ?>"
                                        data-telefone="<?= htmlspecialchars($transportador['telefone']) ?>"
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
                                Nenhum transportador cadastrado.
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