<?php

if ($_POST) {
//    $_POST["Nome"];
//    $_POST["Email"];
//    $_POST["Assunto"];
//    $_POST["Fone"];
//    $_POST["Mensagem"];

    $voltar    = "<script>setTimeout(function(){window.location.href=\"index.html\";},5000);</script>";
    $erro      = false;
    $Nome      = $_POST["Nome"];                 // Pega o valor do campo Nome
    $Email     = $_POST["Email"];              // Pega o valor do campo Email
    $Assunto   = $_POST["Assunto"];         // Pega o valor do campo Assunto
    $Fone      = $_POST["Fone"];              // Pega o valor do campo Telefone
    $Mensagem  = $_POST["Mensagem"];     // Pega o valor do campo Mensagem
    if (empty($Nome && $Fone && $Email && $Mensagem)){
        echo "<div class=\"alert alert-danger\" role=\"alert\">Por favor, preencha o formulario com os seus dados!</div>";
        echo "<script>setTimeout(function () {window.location.href = \"Formulario.php\";}, 5000);</script>";
    }else {

// Verifica se o POST tem algum valor
        if (!isset($_POST) || empty($_POST)) {
            $erro = 'Nada foi postado.';
            echo $voltar;
        }

// Cria as variáveis dinamicamente
        foreach ($_POST as $chave => $valor) {
            // Remove todas as tags HTML
            // Remove os espaços em branco do valor
            $$chave = trim(strip_tags($valor));

            // Verifica se tem algum valor nulo
            if (empty ($valor)) {
                $erro = '<div class="alert alert-danger">Existem campos em branco</div>';
                echo $voltar;
            }
        }
//
        if ( ( ! isset( $Email ) || ! filter_var( $Email, FILTER_VALIDATE_EMAIL ) ) && !$erro ) {
            $erro = '<div class="alert alert-warning" role="alert">Envie um email válido.</div>';
            echo $voltar;
        }
//
// // Verifica se $Nome realmente existe e se é um número.
//// Também verifica se não existe nenhum erro anterior
        if ( ( ! isset( $Nome ) || ! is_string( $Nome ) ) && !$erro ) {
            $erro = '<div class="alert alert-warning" role="alert">Preencha o nome.</div>';
            echo $voltar;
        }
//
// // Verifica se $Assunto realmente existe e se é uma URL.
//// Também verifica se não existe nenhum erro anterior
        if ( ( ! isset( $Assunto ) || ! is_string( $Assunto) ) && !$erro ) {
            $erro = '<div class="alert alert-warning" role="alert">Preencha o assunto.</div>';
            echo $voltar;
        }
//
// // Verifica se $Fone realmente existe e se é um email.
//// Também verifica se não existe nenhum erro anterior
//if ( ( ! isset( $Fone ) || ! is_numeric( $Fone ) ) && !$erro ) {
//    $erro = '<div class="alert alert-warning" role="alert">Preencha o telefone.</div>';
//    echo $voltar;
//}
//
        if ( ( ! isset( $Mensagem ) || ! is_string( $Mensagem ) ) && !$erro ) {
            $erro = '<div class="alert alert-warning" role="alert">Preencha o campo mensagem.</div>';
            echo $voltar;
        }

// Se existir algum erro, mostra o erro
        if ($erro) {
            echo $erro;
        } else {

            $Vai = "Nome: $Nome\n\nE-mail: $Email\n\nAssunto: $Assunto\n\nTelefone: $Fone\n\nMensagem: $Mensagem";

            require_once("phpmailer/class.phpmailer.php");

            define('GUSER', 'william.armstrong50@gmail.com');    // <-- Insira aqui o seu GMail
            define('GPWD', 'Wkm223165');                        // <-- Insira aqui a senha do seu GMail

            function smtpmailer($para, $de, $de_nome, $assunto, $corpo)
            {
                global $error;

                $mail = new PHPMailer();
                $mail->IsSMTP();                       // Ativar SMTP
                $mail->SMTPDebug = 0;                 // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
                $mail->SMTPAuth = true;              // Autenticação ativada
                $mail->SMTPSecure = 'tls';          // SSL REQUERIDO pelo GMail
                $mail->Host = 'smtp.gmail.com';    // SMTP utilizado
                $mail->Port = 587;                // A porta 587 deverá estar aberta em seu servidor
                $mail->Username = GUSER;
                $mail->Password = GPWD;
                $mail->SetFrom($de, $de_nome);
                $mail->Subject = $assunto;
                $mail->Body = $corpo;
                $mail->AddAddress($para);

                if (!$mail->Send()) {
                    $error = 'Mail error: ' . $mail->ErrorInfo;
                    return false;
                } else {
//            $error = 'Mensagem enviada!';
                    return true;
                }
            }

            /*Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER),
            o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.*/

            if (smtpmailer('william.aquino@atitude.com.br', 'william.aquino@atitude.com.br', 'Hotel Paraiso',
                'Hotel Paraiso',
                $Vai)) {
                echo '<div class="alert alert-success jumbotron" role="alert">' . $Nome . ', seu E-mail foi enviado com sucesso!<hr>
<span>Nome: </span>' . $Nome . '<br><span>Email: </span>' . $Email . '<br><span>Assunto: </span>' . $Assunto . '<br><span>Mensagem: </span>' . $Mensagem . '</div>';
                echo $voltar;
//        Header("location:aviso.php"); // Redireciona para uma página de obrigado.
            }

            if (!empty($error)) {
                echo $error;
            }
            // Se a variável erro continuar com valor falso
            // Você pode fazer o que preferir aqui, por exemplo,
            // enviar para a base de dados, ou enviar um email
            // Tanto faz. Vou apenas exibir os dados na tela.
            // echo "<h1> Veja os dados enviados</h1>";
            //    foreach ( $_POST as $chave => $valor ) {
            //        echo '<b>' . $chave . '</b>: ' . $valor . '<br><br>';
        }
    }

}

//}

// Variável que junta os valores acima e monta o corpo do email