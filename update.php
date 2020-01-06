<?php
// Inclui Arquivo de Configuração
require_once "config.php";
 
// Define variáveis e inicializa com valores vazios
$name = $email = $phone = $content = "";
$name_err = $email_err = $phone_err = $content_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Obter valor de entrada oculto
    $id = $_POST["id"];
    
    // Validar Nome
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor insira um nome.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Por favor, informe um nome válido.";
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
    
    // Verifica os erros de entrada antes de inserir no banco de dados
    if(empty($name_err) && empty($email_err) && empty($phone_err) && empty($content_err)){
        // Prepare uma declaração de atualização
        $sql = "UPDATE form SET name=:name, email=:email, phone=:phone, content=:content WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Vincular variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":email", $param_email);
            $stmt->bindParam(":phone", $param_phone);
            $stmt->bindParam(":content", $param_content);
            $stmt->bindParam(":id", $param_id);
            
            // Definir parâmetros
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_content = $content;
            $param_id = $id;
            
            // Tentativa de executar a declaração preparada
            if($stmt->execute()){
                // Registros atualizados com sucesso. Redirecionar para a página de destino
                header("location: index.php");
                exit();
            } else{
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
         
        // Fechar declaração
        unset($stmt);
    }
    
    // Fechar conexão
    unset($pdo);
} else{
    // Verifique a existência do parâmetro id antes de processar mais
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Obter parâmetro de URL
        $id =  trim($_GET["id"]);
        
        // Prepara uma declaração de seleção
        $sql = "SELECT * FROM form WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Vincular variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":id", $param_id);
            
            // Definir parâmetros
            $param_id = $id;
            
            // Tentativa de executar a declaração preparada
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Busque a linha de resultados como um array associativa. Como o conjunto de resultados contém apenas uma linha, não precisamos usar o loop while */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Recuperar valor do campo individual
                    $name = $row["name"];
                    $email = $row["email"];
                    $phone = $row["phone"];
                    $content = $row["content"];
                } else{
                    // O URL não contém um ID válido. Redirecionar para a página de erro
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
        
        // Fechar declaração
        unset($stmt);
        
        // Fechar conexão
        unset($pdo);
    }  else{
        // O URL não contém o parâmetro id. Redirecionar para a página de erro
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Atualizar Registro</h2>
                    </div>
                    <p>Edite os campos desejados e envie para atualizar o registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Telefone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
                            <label>Conteúdo</label>
                            <textarea name="content" class="form-control"><?php echo $content; ?></textarea>
                            <span class="help-block"><?php echo $content_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Eniar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>