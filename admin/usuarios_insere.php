<?php
include 'acesso_com.php';
include '../conn/connect.php';
// implementação backend a partir daqui...
 
if($_POST)
{
    $id = $_POST['id'];
    $login = $_POST['login'];
    md5($nivel = $_POST['id_nivel']);
    $senha = $_POST['senha'];

    $inserindo = "INSERT INTO usuarios (login, nivel, senha) VALUES('$login', '$nivel', $senha)";

    $inserindo = $conn -> query($inserindo);
    if (mysqli_insert_id($conn)){

        header('location:usuarios_lista.php');
    }

}

$listaTipo = $conn -> query("SELECT nivel FROM usuarios;");
$rowTipo = $listaTipo -> fetch_assoc();
$numLinhas = $listaTipo -> num_rows;

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
                    Insere Usuários
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-danger" role="alert">
                        <form action="usuarios_insere.php" method="post" name="form_insere"
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
                                    placeholder="Digite o login do Usuário" maxlength="50">
                            </div>
                            <label for="senha">Senha:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                </span>
                                <input type="password" name="senha" id="senha" class="form-control"
                                    placeholder="Digite a senha do Usuário" maxlength="12">
                            </div>
                            
                            <label for="nivel">Nível:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                                </span>

                                <select name="id_nivel" id="id_nivel" class="form-control" required>
                                    
                                    <option value="com">
                                        <!-- buscar tipo -->
                                        Comum
                                    </option>
                                    <option value="sup">
                                        <!-- buscar tipo -->
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