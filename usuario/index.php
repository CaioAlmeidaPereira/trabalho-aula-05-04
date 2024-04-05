<?php
include_once 'conexao.php';
include_once 'usuario.php';

$conexao_banco = new Conexao();
$banco = $conexao_banco->conectar();

$nome = new Nome($banco);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nome']) && !empty($_POST['telefone'])) {
        $nome->nome = $_POST['nome'];
        $nome->telefone = $_POST['telefone'];

        if ($nome->criar()) {
            echo "<p>nome criado com sucesso.</p>";
        } else {
            echo "<p>Não foi possível criar o nome.</p>";
        }
    } else {
        echo "<p>Por favor, preencha todos os campos.</p>";
    }
}

$stmt = $nome->ler();
$num = $stmt->rowCount();

if ($num > 0) {
    echo "<h2>usuarios Cadastrados</h2>";
    echo "<div class='lista-nomes'>";
    echo "<ul>"; 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<li>ID: {$id}, nome: {$nome}, telefone: {$telefone}</li>";
    }
    echo "</ul>";
    echo "</div>";
} else {
    echo "<p>Nenhum usuario cadastrado.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de nomes</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Adicionar Novo nome</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nome">nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="telefone">telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <input type="submit" value="Adicionar nome">
        </form>
    </div>
    <script>
        $(document).ready(function(){
            $('#telefone').mask('(00)0 0000-0000');
        });
    </script>
</body>
</html>
