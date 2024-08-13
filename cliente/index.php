<?php
include '../conn/connect.php';
// implementação backend a partir daqui...

if($_POST)
{
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    $inserindo = "INSERT INTO cliente (Nome, Email, Telefone, CPF) VALUES('$nome', '$email', $telefone, $cpf)";

    $inserindo = $conn -> query($inserindo);
    if (mysqli_insert_id($conn)){

        header('location: ../index.php');
    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Clientes - Insere</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
                <h2 class="breadcrumb text-danger">
                    <a href="../index.php">
                        <button class="btn btn-danger">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                    </a>
                    Insere Cliente
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-danger" role="alert">
                        <form action="index.php" method="post" name="form_insere"
                            enctype="multipart/form-data" id="form_insere">

                            <label for="nome">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="nome" id="nome" class="form-control"
                                    placeholder="Digite o nome do Cliente" maxlength="100" required>
                            </div>

                            <label for="email">Email:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                </span>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Digite o email do Cliente" maxlength="100" required>
                            </div>

                            <label for="telefone">Telefone:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                                </span>
                                <input type="number" name="telefone" id="telefone" class="form-control"
                                    placeholder="Digite o telefone do Cliente" maxlength="15">
                            </div>

                            <label for="cpf">CPF:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                                </span>
                                <input type="number" name="cpf" id="cpf" class="form-control"
                                    placeholder="Digite o CPF do Cliente" maxlength="14" required>
                            </div>
                            
                            <br>
                            <input type="submit" name="Inserir" id="Inserir" class="btn btn-danger btn-block"
                                value="Inserir">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
