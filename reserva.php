<?php

include 'conn/connect.php';

session_name('chuleta');
session_start();

if ($_POST) {
    $data = $_POST['data-limite'];
    $horario = $_POST['horario'];
    $motivo = $_POST['motivo'];
    $pessoas = $_POST['pessoas'];

    if (isset($_SESSION['cliente_id'])) {
        $cliente_id = $_SESSION['cliente_id'];
    } else {
        // Redireciona para login se o cliente não estiver logado
        header('Location: admin/login.php');
        exit();
    }

    $dataFormatada = date("Y-m-d", strtotime($data));

    // Verifica se já existe uma reserva para este cliente na data selecionada
    $consulta = "SELECT * FROM reserva WHERE id_cliente = $cliente_id AND data_reserva = '$dataFormatada'";
    $resultado = $conn->query($consulta);

    if ($resultado->num_rows > 0) {
        echo "Você já tem uma reserva para esta data. Apenas uma reserva é permitida por dia.";
        exit();
    }

    // Verifica se a data está dentro do intervalo permitido (mínimo 24 horas, máximo 30 dias)
    $hoje = date("Y-m-d");
    $dataMin = date("Y-m-d", strtotime("+1 day"));
    $dataMax = date("Y-m-d", strtotime("+30 days"));

    if ($dataFormatada < $dataMin || $dataFormatada > $dataMax) {
        echo "A data da reserva deve ser entre 24 horas e 30 dias a partir de hoje.";
        exit();
    }

    // Insere a nova reserva
    $inserindo = "INSERT INTO reserva (data_reserva, horario, motivo, id_cliente, numero_pessoas)
                  VALUES('$dataFormatada', '$horario', '$motivo', $cliente_id, $pessoas)";
    
    if ($conn->query($inserindo) === TRUE) {
        header('Location: lista_reservas_cliente.php');
    } else {
        echo "Falha ao registrar a reserva.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Clientes - Insere</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
                <h2 class="breadcrumb text-danger">
                    <a href="lista_reservas_cliente.php">
                        <button class="btn btn-danger">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                    </a>
                    RESERVA
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-danger" role="alert">
                        <form action="reserva.php" method="post" name="form_insere"
                            enctype="multipart/form-data" id="form_insere">

                            <label for="data">Data:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="date" name="data-limite" id="data-limite" class="form-control"
                                     required>
                            </div>
                            <label for="horario">Horário:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="time" name="horario" id="horario" class="form-control"
                                     maxlength="100" required>
                            </div>

                            <div>
                            <label for="pessoas">Números de Pessoas:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="number" name="pessoas" id="pessoas" class="form-control"
                                min="1" max="12" required>
                            </div>

                            <label for="motivo">Motivo:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                </span>
                                <input type="motivo" name="motivo" id="motivo" class="form-control"
                                    placeholder="Digite o motivo da reserva (Opicional!!!)" maxlength="100">
                            </div>
                            <h3>REGRAS:</h3>
                            <h5>no mínimo 24 horas de antecedência e no máximo 30 dias. Apenas um pedido de reserva por dia para um mesmo CPF</h5>
                            
                            <br>
                            <input type="submit" name="registrar" id="registrar" class="btn btn-danger btn-block"
                                value="Registrar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<script>
    // Obtém a data atual
    const hoje = new Date();

    // Formata a data como 'AAAA-MM-DD'
    const ano = hoje.getFullYear();
    const mes = String(hoje.getMonth() + 1).padStart(2, '0'); // Adiciona 1 porque os meses são indexados em 0
    const dia = String(hoje.getDate()).padStart(2, '0');

    // Define o valor mínimo do campo de data como o dia de hoje
    const dataLimiteInput = document.getElementById('data-limite');
    dataLimiteInput.min = `${ano}-${mes}-${dia}`;
</script>

