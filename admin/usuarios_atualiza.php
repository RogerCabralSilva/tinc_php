<?php
include 'acesso_com.php';
include '../conn/connect.php';

// Se clicou no botão
if ($_POST) 
{
    $id = $_POST['id'];
    $login = $_POST['login'];
    $nivel = $_POST['id_nivel'];
    $senha = $_POST['senha'];

    $update = "UPDATE usuarios SET login = '$login', nivel = '$nivel', senha = $senha
                WHERE id = $id ";
    $resultado = $conn -> query($update);
    if ($resultado) 
    {
        header('location:usuarios_lista.php');
    }

}
if($_GET) 
{
    $id_form = $_GET['id'];
}else {
    $id_form = 0;
}
$lista = $conn -> query("SELECT * FROM usuarios WHERE id = $id_form");
$row = $lista -> fetch_assoc();

$listaTipo = $conn -> query("SELECT nivel FROM usuarios");
$rowTipo = $listaTipo -> fetch_assoc();
$numLinha = $listaTipo -> num_rows;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Usuários - Insere</title>
</head>

<body>
    <?php include "menu_adm.php";?>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
                <h2 class="breadcrumb text-danger">
                    <a href="usuarios_lista.php">
                        <button class="btn btn-danger">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                    </a>
                    Atualiza Usuários
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-danger" role="alert">
                        <form action="usuarios_atualiza.php" method="post" name="form_insere"
                            enctype="multipart/form-data" id="form_insere">

                            <input type="hidden" name="id" id="id" value="<?php echo $row['id'];?>">
                            <div class="input-group">
                            </div>
                            <label for="login">Login:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="login" id="login" class="form-control"
                                    placeholder="Digite o login do Usuário" maxlength="50" value="<?php echo $row['login']; ?>">
                            </div>
                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" id="senha" class="form-control"
                                    placeholder="Digite a senha do Usuário" maxlength="12" value="<?php echo $row['senha']?>">
                            </div>

                            <label for="nivel">Nível:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                                </span>

                                <select name="id_nivel" id="id_nivel" class="form-control" required>

                                    <option value="com" 
                                        <?php 
                                            if((!strcmp("com", $row['nivel']))){
                                                echo "selected=\"selected\"";
                                            }
                                        ?>
                                    >
                                        Comum
                                    </option>
                                    <option value="sup" 
                                        <?php 
                                            if((!strcmp("sup", $row['nivel']))){
                                                echo "selected=\"selected\"";
                                            }
                                        ?>
                                    >
                                        Super
                                    </option>

                                </select>
                                <br>
                            </div>
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