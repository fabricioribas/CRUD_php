<?php
// Processar operação de exclusão após confirmação
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Incluir arquivod de configuração
    require_once "config.php";
    
    // Prepare uma instrução de exclusão
    $sql = "DELETE FROM form WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Vincular variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":id", $param_id);
        
        // Definir parâmetros
        $param_id = trim($_POST["id"]);
        
        // Tentativa de executar a declaração preparada
        if($stmt->execute()){
            // Registros excluídos com sucesso. Redirecionar para a página de destino
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }
    }
     
    // Fechar declaração
    unset($stmt);
    
    // Fechar conexão
    unset($pdo);
} else{
    // Verifique a existência do parâmetro id
    if(empty(trim($_GET["id"]))){
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
    <title>Exibir Registro</title>
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
                        <h1>Apagar Registro</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Tem certeza de que deseja excluir este registro?</p><br>
                            <p>
                                <input type="submit" value="Sim" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">Não</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>