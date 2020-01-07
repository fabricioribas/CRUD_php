<?php
// Verifique a existência do parâmetro ID antes de processar seguir
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Incluir arquivo de configuração
    require_once "config.php";
    
    // Prepare uma declaração de seleção
    $sql = "SELECT * FROM form WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Vincular variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":id", $param_id);
        
        // Definir parâmetros
        $param_id = trim($_GET["id"]);
        
        // Tentativa de executar a declaração preparada
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Busque a linha de resultados como uma matriz associativa. Como o conjunto de resultados contém apenas uma linha, não precisamos usar o loop while */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Recuperar valor do campo individual
                $name = $row["name"];
                $email = $row["email"];
                $phone = $row["phone"];
                $content = $row["content"];
            } else{
                // O URL não contém um parâmetro de identificação válido. Redirecionar para a página de erro
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Fechar declaração
    unset($stmt);
    
    // Fechar conexão
    unset($pdo);
} else{
    // O URL não contém o parâmetro id. Redirecionar para a página de erro
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>Exibir Registro</h1>
                    </div>
                    <div class="form-group">
                        <label>Nome</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <p class="form-control-static"><?php echo $row["phone"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Conteúdo</label>
                        <p class="form-control-static"><?php echo $row["content"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Voltar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>