<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Importar classes do PHPMailer para o espaço de nomes global
// Eles devem estar no topo do seu script, não dentro de uma função
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 // Adiciona o arquivo class.phpmailer.php - você deve especificar corretamente o caminho da pasta com o este arquivo.
 require_once("vendor/autoload.php");
 // Inicia a classe PHPMailer
 $mail = new PHPMailer();

 // DEFINIÇÃO DOS DADOS DE AUTENTICAÇÃO - Você deve auterar conforme o seu domínio!
 
 // Define que a mensagem será SMTP
 $mail->IsSMTP(); 

// Seu endereço de host SMTP
 $mail->Host = "smtp-avancado.com"; 
 
 // Define que será utilizada a autenticação -  Mantenha o valor "true"
 $mail->SMTPAuth = true; 
 
 // Porta de comunicação SMTP - Mantenha o valor "587"
 $mail->Port = 587; 
 
 // Define se é utilizado SSL/TLS - Mantenha o valor "false"
 $mail->SMTPSecure = false; 
 
 // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
 $mail->SMTPAutoTLS = false; 
 
 // Conta de email existente e ativa em seu domínio
 $mail->Username = 'contato@superprogresso.com.br'; 
 
 // Senha da sua conta de email
 $mail->Password = 'xVC6iFef'; 
 
 // DADOS DO REMETENTE
 
 // Conta de email existente e ativa em seu domínio
 $mail->Sender = "contato@superprogresso.com.br"; 
 
 // Sua conta de email que será remetente da mensagem
 $mail->From = "contato@superprogresso.com.br"; 
 
 // Nome da conta de email
 $mail->FromName = "Contato"; 
 
 // DADOS DO DESTINATÁRIO
 
 // Define qual conta de email receberá a mensagem
 $mail->AddAddress('fabricioaribas@gmail.com', 'Fabrício - Recebe Formulário'); 
 //$mail->AddAddress('recebe2@dominio.com.br'); // Define qual conta de email receberá a mensagem
 //$mail->AddCC('copia@dominio.net'); // Define qual conta de email receberá uma cópia
 //$mail->AddBCC('copiaoculta@dominio.info'); // Define qual conta de email receberá uma cópia oculta
 
 
 // Definição de HTML/codificação
 // Define que o e-mail será enviado como HTML
 $mail->IsHTML(true); 
 
 // Charset da mensagem (opcional)
 $mail->CharSet = 'UTF-8'; 

 // DEFINIÇÃO DA MENSAGEM
 // Assunto da mensagem
 $mail->Subject  = "Formulário de Contato"; 
 $mail->Body .= " Nome: ".$_POST['name']/n; 
// Texto da mensagem
 $mail->Body .= " E-mail: ".$_POST['email']/n; 
// Texto da mensagem
 $mail->Body .= " Telefone: ".$_POST['phone']/n; 
// Texto da mensagem
 $mail->Body .= " Mensagem: ".nl2br($_POST['content']); 
// Texto da mensagem
 
// ENVIO DO EMAIL
 $enviado = $mail->Send();
//  header("location: index.php");
//  var_dump($enviado);