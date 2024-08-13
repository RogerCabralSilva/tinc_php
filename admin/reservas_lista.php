<?php
include 'acesso_com.php';
include '../conn/connect.php';
$lista = $conn->query("SELECT * FROM vw_reserva");
$row = $lista->fetch_assoc();
$rows = $lista->num_rows;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Lista</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <?php include 'menu_adm.php'; ?>
    <main class="container">
        <h2 class="breadcrumb alert-danger">Lista de Reservas</h2>
        <table class="table table-hover table-condensed tb-opacidade bg-warning">
            <thead>
                <th class="hidden">ID</th>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>DATA DA RESERVA</th>
                <th>HORÁRIO</th>
                <th>MOTIVO</th>
                <th>STATUS</th>
            </thead>

            <tbody> <!-- início corpo da tabela -->
                <!-- início estrutura repetição -->
                <?php do { ?>
                    <tr>
                        <td>
                            <?php echo $row['Nome']?>
                        </td>
                        <td>
                            <?php echo $row['Email']?>
                        </td>
                        <td>
                            <?php echo $row['data_reserva']?>
                        </td>
                        <td>
                            <?php echo $row['horario']?>
                        </td>
                        <td>
                            <?php echo $row['motivo']?>
                        </td>
                        <td>
                            <?php echo $row['status']?>
                        </td>
                        <td>
                            <button data-nome="<?php echo $row['nome']; ?>" data-id="<?php echo $row['id']; ?>"
                                class="delete btn btn-xs btn-block btn-danger <?php echo $regraRow['destaque']=='Sim'?'hidden':''?>">
                                <span class="glyphicon glyphicon-trash"></span>
                                <span class="hidden-xs">EXCLUIR</span>
                            </button>
                        </td>
                    </tr>
                <?php } while ($row = $lista->fetch_assoc()) ?>
            </tbody><!-- final corpo da tabela -->
        </table>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
    $('.delete').on('click', function () {
        var nome = $(this).data('nome'); //busca o nome com a descrição (data-nome)
        var id = $(this).data('id'); // busca o id (data-id)
        //console.log(id + ' - ' + nome); //exibe no console
        $('span.nome').text(nome); // insere o nome do item na confirmação
        $('a.delete-yes').attr('href', 'produtos_excluir.php?id=' + id); //chama o arquivo php para excluir o produto
        $('#modalEdit').modal('show'); // chamar o modal
    });
</script>

<?php

?>

</html>