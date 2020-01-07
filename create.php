<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclui Arquivo de Configuração
require_once "config.php";
 
// Define variáveis e inicializa com valores vazios
$name = $email = $phone = $content= "";
$name_err = $email_err = $phone_err = $content_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validar Nome
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor insira um nome.";
    } else{
        $name = $input_name;
    }
    
    // Validar E-mail
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor, insira um e-mail.";     
    } elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Por favor, informe um e-mail válido.";
    } else{
        $email = $input_email;
    }
    
    // Validar Telefone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Por favor, informe um número de telefone";
    } else{
        $phone = $input_phone;
    }

    // Validar Conteúdo
    $input_content = trim($_POST["content"]);
    if(empty($input_content)){
        $content_err = "Por favor, nos informe o motivo do seu contato!";     
    } else{
        $content = $input_content;
    }
    
    // Verifica os erros de entrada antes de inserir no Banco de Dados
    if(empty($name_err) && empty($email_err) && empty($phone_err) && empty($content_err)){
        // Prepare uma instrução de inserção
        $sql = "INSERT INTO form (name, email, phone, content) VALUES (:name, :email, :phone, :content)";
         
        if($stmt = $pdo->prepare($sql)){
            
            //Vincula variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":phone", $param_phone);
            $stmt->bindParam(":content", $param_content);
            
            //Definir parâmetros
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_content = $content;
            
            // Tentativa de executar a declaração
            if($stmt->execute()){
                // Registros criados com sucesso. Redirecionar para a página de destino
                include "send_email.php"; //envia o email
                header("location: index.php");
                exit();
            } else{
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        
        } 
        // Fechar declaração
        unset($stmt);
    }
    
    // Fecha a Conexão
    unset($pdo);
}    
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Criar registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Formulário de Contato</h2>
                    </div>
                    <p>Preencha esta formulário para entrar em Contato conosco.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" placeholder="Nome" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" placeholder="E-mail" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Telefone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Telefone" value="<?php echo $phone; ?>">
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
                            <label>Conteúdo</label>
                            <textarea name="content" class="form-control" placeholder="Deixe sua mensagem!"><?php echo $content; ?></textarea>
                            <span class="help-block"><?php echo $content_err;?></span>
                        </div>
                        <input action="send_email.php" type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>