<?php
include 'acesso_com.php';
include '../conn/connect.php';

// classes do php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// dados da pasta vender
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

// Se o botão confirmar for apertado
if (isset($_POST['confirmar'])) {
    $id_reserva = $_POST['id_reserva'];
    $cpf_cliente = $_POST['cpf_cliente'];
    $email_cliente = $_POST['email_cliente'];
    $nome = $_POST['Nome'];
    $numero_mesa = $_POST['mesa'];

    $cpf_digitos = substr($cpf_cliente, 0, 3);
    $codigo = $cpf_digitos . $id_reserva . rand(10000, 99999);

    $sql = "UPDATE reserva SET status='Confirmada', mesa='$numero_mesa' WHERE id_reserva='$id_reserva'";

    if ($conn->query($sql)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cabralroger159@gmail.com';
            $mail->Password   = 'bbpd akhw yngi fgyk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom($email_cliente, $nome);
            $mail->addAddress($email_cliente);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Reserva';
            $mail->Body    = "Sua reserva foi aceita! Seu código de confirmação é: <b>$codigo</b><br>Número da mesa: <b>$numero_mesa</b>";

            $mail->send();
            echo 'Email enviado com sucesso!';
        } catch (Exception $e) {
            echo "Erro ao enviar o email: {$mail->ErrorInfo}";
        }
    } else {
        echo "Erro ao atualizar o status da reserva: " . $conn->error;
    }
}

// Se o botão rejeitar for apertado
if (isset($_POST['rejeitar'])) {
    $id_reserva = $_POST['id_reserva'];
    $motivo_rejeicao = $_POST['motivo_rejeicao'];
    $email_cliente = $_POST['email_cliente'];
    $nome = $_POST['Nome'];

    $sql = "UPDATE reserva SET status='Cancelada' WHERE id_reserva='$id_reserva'";
    if ($conn->query($sql)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cabralroger159@gmail.com';
            $mail->Password   = 'bbpd akhw yngi fgyk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom($email_cliente, $nome);
            $mail->addAddress($email_cliente);

            $mail->isHTML(true);
            $mail->Subject = 'Reserva Rejeitada';
            $mail->Body    = "Sua reserva foi rejeitada. Motivo: <b>$motivo_rejeicao</b>";

            $mail->send();
            echo 'Email enviado com sucesso!';
        } catch (Exception $e) {
            echo "Erro ao enviar o email: {$mail->ErrorInfo}";
        }
    } else {
        echo "Erro ao atualizar o status da reserva: " . $conn->error;
    }
}

// Atualizar status para "Vencida" se a reserva for mais antiga que 24 horas
$data_atual = date('Y-m-d H:i:s');
$sql = "UPDATE reserva SET status='Vencida' WHERE status='Confirmada' AND TIMESTAMPDIFF(HOUR, data_reserva, '$data_atual') >= 24";

if ($conn->query($sql)) {
    echo "Status das reservas atualizado com sucesso!";
} else {
    echo "Erro ao atualizar o status das reservas: " . $conn->error;
}

// Lista para exibir e pegar os dados view
$lista = $conn->query("SELECT * FROM vw_reserva");
$row = $lista->fetch_assoc();
$rows = $lista->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
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
                <th>AÇÕES</th>
            </thead>
            <tbody>
                <?php do { ?>
                    <tr>
                        <td><?php echo $row['Nome'] ?></td>
                        <td><?php echo $row['Email'] ?></td>
                        <td><?php echo $row['data_reserva'] ?></td>
                        <td><?php echo $row['horario'] ?></td>
                        <td><?php echo $row['motivo'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id_reserva" value="<?php echo $row['id_reserva']; ?>">
                                <input type="hidden" name="cpf_cliente" value="<?php echo $row['CPF']; ?>">
                                <input type="hidden" name="email_cliente" value="<?php echo $row['Email']; ?>">
                                <input type="hidden" name="Nome" value="<?php echo $row['Nome']; ?>">
                                <button type="button" class="btn btn-xs btn-block btn-success confirmar-btn" data-id-reserva="<?php echo $row['id_reserva']; ?>" data-email-cliente="<?php echo $row['Email']; ?>" data-nome="<?php echo $row['Nome']; ?>" data-cpf-cliente="<?php echo $row['CPF'] ?>">
                                    Confirmar
                                </button>
                            </form>
                            <button type="button" class="btn btn-xs btn-block btn-danger rejeitar-btn" data-id-reserva="<?php echo $row['id_reserva']; ?>" data-email-cliente="<?php echo $row['Email']; ?>" data-nome="<?php echo $row['Nome']; ?>">
                                Rejeitar
                            </button>
                        </td>
                    </tr>
                <?php } while ($row = $lista->fetch_assoc()) ?>
            </tbody>
        </table>
    </main>

    <!-- Modal para Confirmar Reserva -->
    <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarModalLabel">Confirmar Reserva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmarForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_reserva" id="modal_id_reserva">
                        <input type="hidden" name="cpf_cliente" id="modal_cpf_cliente">
                        <input type="hidden" name="email_cliente" id="modal_email_cliente">
                        <input type="hidden" name="Nome" id="modal_nome">
                        <div class="form-group">
                            <label for="mesa">Número da Mesa</label>
                            <input type="text" class="form-control" name="mesa" id="mesa" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="confirmar" class="btn btn-success">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Rejeição -->
    <div class="modal fade" id="rejeitarModal" tabindex="-1" role="dialog" aria-labelledby="rejeitarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejeitarModalLabel">Rejeitar Reserva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejeitarForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_reserva" id="modal_id_reserva_rejeitar">
                        <input type="hidden" name="cpf_cliente" id="modal_cpf_cliente_rejeitar">
                        <input type="hidden" name="email_cliente" id="modal_email_cliente_rejeitar">
                        <input type="hidden" name="Nome" id="modal_nome_rejeitar">
                        <div class="form-group">
                            <label for="motivo_rejeicao">Motivo da Rejeição</label>
                            <textarea class="form-control" name="motivo_rejeicao" id="motivo_rejeicao" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="rejeitar" class="btn btn-danger">Rejeitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Configurar o modal de confirmação
            $('button.confirmar-btn').on('click', function() {
                var id_reserva = $(this).data('id-reserva');
                var email_cliente = $(this).data('email-cliente');
                var cpf_cliente = $(this).data('cpf-cliente');
                var nome = $(this).data('nome');

                $('#modal_id_reserva').val(id_reserva);
                $('#modal_cpf_cliente').val(cpf_cliente);;
                $('#modal_email_cliente').val(email_cliente);
                $('#modal_nome').val(nome);

                $('#confirmarModal').modal('show');
            });

            // Configurar o modal de rejeição
            $('button.rejeitar-btn').on('click', function() {
                var id_reserva = $(this).data('id-reserva');
                var email_cliente = $(this).data('email-cliente');
                var cpf_cliente = $(this).data('cpf-cliente');
                var nome = $(this).data('nome');

                $('#modal_id_reserva_rejeitar').val(id_reserva);
                $('#modal_cpf_cliente_rejeitar').val(cpf_cliente);
                $('#modal_email_cliente_rejeitar').val(email_cliente);
                $('#modal_nome_rejeitar').val(nome);

                $('#rejeitarModal').modal('show');
            });
        });
    </script>
</body>

</html>