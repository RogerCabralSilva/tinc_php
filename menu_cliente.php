<?php
 
    include "conn/connect.php";
    $lista_tipos = $conn->query("SELECT * FROM tipos ORDER BY rotulo");
    $rows_tipos = $lista_tipos->fetch_all(); // me traga todos na forma de matriz
 
?>
 
<!-- conteúdo -->
 
<!-- abre a barra de navegação -->
<nav class="navbar navbar-expanded-md navbar-fixed-top navbar-light navbar-inverse">
 
    <div class="container-fluid">
        <!-- Agrupamento Mobile -->
        <div class="navbar-header">
           
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#menupublico">
                <span class="sr-only">Toggle Navegation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
 
        <a href="index.php" class="navbar-brand">
            <img src="images/logo-chuleta.png" alt="Logotipo Chuleta Quente">
        </a>
 
        </div>
        <!-- Fecha agrupamento Mobile -->
        <!-- nav direita -->
 
        <div class="collapse navbar-collapse" id="menupublico">
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a href="index.php">
                    <span class="glyphicon glyphicon-home"></span>
                    </a>
                </li>
                <!-- Dropdown -->
                <!-- Fim do dropdown -->
            </ul>
        </div>
    </div>
 
</nav>
