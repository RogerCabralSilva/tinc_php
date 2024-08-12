<?php
include 'acesso_com.php';
include '../conn/connect.php';
// implementação backend a partir daqui...
 
if($_POST)
{
    $id = $_POST['id'];
    $sigla = $_POST['sigla'];
    $rotulo = $_POST['rotulo'];

    $inserindo = "INSERT INTO tipos (rotulo, sigla) VALUES('$rotulo', '$sigla')";

    $inserindo = $conn -> query($inserindo);
    if (mysqli_insert_id($conn)){

        header('location:tipos_lista.php');
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
    <title>Produto - Insere</title>
</head>
<body>
<?php include "menu_adm.php";?>
    <main class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
                <h2 class="breadcrumb text-danger">
                    <a href="tipos_lista.php">
                        <button class="btn btn-danger">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                    </a>
                    Insere Tipos
                </h2>
                <div class="thumbnail">
                    <div class="alert alert-danger" role="alert">
                        <form action="tipos_insere.php" method="post" name="form_insere"
                            enctype="multipart/form-data" id="form_insere">

                            <input type="hidden" name="id" id="id" value="<?php echo $row['id'];?>">
                            <div class="input-group">
                            </div>
                            <label for="rotulo">Rótulo:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="rotulo" id="rotulo" class="form-control"
                                    placeholder="Digite o rótulo do Produto" maxlength="100">
                            </div>
                            <label for="sigla">Sigla:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-text-background" aria-hidden="true"></span>
                                </span>
                                <input type="text" name="sigla" id="sigla" class="form-control"
                                    placeholder="Digite a sigla do Produto" maxlength="3">
                                <br><br>
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