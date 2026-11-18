<?php

$pagina = $_GET['pagina'] ?? 'inicio';

$paginas = [
    'produtos' => 'Produtos',
    'enderecos' => 'Enderecos',
    'transportadores' => 'Transportadores',
    'fretes' => 'Gerenciar Fretes'
];

$titulo = $paginas[$pagina] ?? 'LogiTrack';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $titulo; ?> | LogiTrack</title>

    <!--CSS página-->
    <link rel="stylesheet" href="assets/CSS/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <!-- Menu lateral -->
    <aside class="menu-lateral">

        <h4>LOGITRACK</h4>
        <div class="subtitulo">Gestão Logística</div>

        <div class="menu-titulo">CADASTROS</div>

        <a href="index.php?pagina=produtos"
            class="<?php echo $pagina == 'produtos' ? 'active' : ''; ?>">
            <i class="bi bi-box-seam"></i> Produtos
        </a>

        <a href="index.php?pagina=enderecos"
            class="<?php echo $pagina == 'enderecos' ? 'active' : ''; ?>">
            <i class="bi bi-geo-alt"></i> Endereços
        </a>

        <a href="index.php?pagina=transportadores"
            class="<?php echo $pagina == 'transportadores' ? 'active' : ''; ?>">
            <i class="bi bi-truck"></i> Transportadores
        </a>

        <div class="menu-titulo">OPERAÇÕES</div>

        <a href="index.php?pagina=fretes"
            class="<?php echo $pagina == 'fretes' ? 'active' : ''; ?>">
            <i class="bi bi-clipboard-check"></i> Gerenciar Fretes
        </a>

    </aside>


    <!-- Conteúdo principal -->
    <main class="main-content">

        <div class="content-card">

            <?php

            $arquivo = "pages/" . $pagina . ".php";

            if (isset($paginas[$pagina]) && file_exists($arquivo)) {

                include $arquivo;

            } elseif ($pagina == 'inicio') {

                echo "<h2>Bem-vindo ao LogiTrack!</h2>";
                echo "<p class='text-muted'>Selecione uma opção no menu lateral para começar.</p>";

            } else {

                echo "<h2>Página não encontrada</h2>";
                echo "<p class='text-muted'>A página solicitada não está disponível.</p>";

            }

            ?>

        </div>

    </main>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/JS/script.js"></script>

</body>
</html>