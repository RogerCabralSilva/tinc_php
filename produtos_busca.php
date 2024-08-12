<?php
include "conn/connect.php";
$busca = $_GET["buscar"];

// Consultas preparadas para prevenir SQL Injection
$stmt = $conn->prepare("SELECT * FROM vw_produtos WHERE descricao LIKE ? OR resumo LIKE ? ORDER BY descricao ASC");
$searchTerm = "%{$busca}%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$listaBusca = $stmt->get_result();
$numLinhas = $listaBusca->num_rows;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Busca por palavra</title>
</head>
<body class="fundofixo">
    <div class="container">
        <?php include "menu_publico.php"?>
        
        <!-- Mostrar se a consulta retornar vazio -->
        <?php if($numLinhas == 0){?>
        <h2 class="breadcrumb alert-danger">
            <a href="javascript:window.history.go(-1)" class="btn btn-danger">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            Não há produtos relacionados com <strong> "<?php echo htmlspecialchars($busca) ?>" </strong>
        </h2>
        <?php }?>

        <!-- Mostrar se a consulta retornou produtos -->
        <?php if ($numLinhas > 0) {?>
        <h2 class="breadcrumb alert-danger">
            <a href="javascript:window.history.go(-1)" class="btn btn-danger">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            Busca por <strong> <?php echo htmlspecialchars($busca); ?></strong>
        </h2>
        <?php }?>
        
        <div class="row">
            <?php while ($row_busca = $listaBusca->fetch_assoc()) {?>
            <!-- Mostre -->
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a href="produto_detalhes.php?id=<?php echo htmlspecialchars($row_busca['id'])?>">
                        <img src="images/<?php echo htmlspecialchars($row_busca['imagem'])?>" alt="" class="img-responsive img-rounded">
                    </a>
                    <div class="caption text-right">
                        <h3 class="text-danger">
                            <strong><?php echo htmlspecialchars($row_busca['descricao']);?></strong>
                        </h3>
                        <p class="text-warning">
                            <strong><?php echo htmlspecialchars($row_busca['rotulo'])?></strong>
                        </p>
                        <p>
                            <button class="btn btn-default disabled">
                                <?php echo "R$" . number_format($row_busca['valor'], 2, ',', '.') ?>
                            </button>
                            <a href="produto_detalhes.php?id=<?php echo htmlspecialchars($row_busca['id']); ?>">
                                <span class="hidden-xs">Saiba mais...</span>
                                <span class="hidden-xs glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </a>
                        </p>
                        <p class="text-left">
                            <?php echo mb_strimwidth(htmlspecialchars($row_busca['resumo']),0,43,'...')?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick.min.js"></script>
    <script>
    $(document).on('ready', function() {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
    });
    </script>
</body>
</html>
