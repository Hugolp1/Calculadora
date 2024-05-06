<?php
session_start();

// Inicializar o histórico se não estiver definido
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

$result = "";
$all_results = ""; // Para armazenar todo o histórico

if (isset($_GET['num1']) && isset($_GET['op'])) {
    $num1 = (float)$_GET['num1'];
    $op = $_GET['op'];

    if ($op !== '!') {
        if (isset($_GET['num2'])) {
            $num2 = (float)$_GET['num2'];

            // Verificar a operação para evitar erros
            switch ($op) {
                case '+':
                    $result = $num1 + $num2;
                    break;
                case '-':
                    $result = $num1 - $num2;
                    break;
                case '*':
                    $result = $num1 * $num2;
                    break;
                case '/':
                    if ($num2 == 0) {
                        $result = "Erro: Divisão por zero não é permitida.";
                    } else {
                        $result = $num1 / $num2;
                    }
                    break;
                case '^':
                    $result = pow($num1, $num2);
                    break;
                default:
                    $result = "Operação inválida";
                    break;
            }

            // Adicionar ao histórico
            $calculation = "$num1 $op $num2 = $result";
            $_SESSION['history'][] = $calculation;

        } else {
            $result = "Erro: O segundo número é necessário para esta operação.";
        }
    } else {
        // Operação de fatorial
        if ($num1 < 0) {
            $result = "Erro: Fatorial de número negativo não é possível.";
        } else {
            $result = 1;
            for ($i = 2; $i <= $num1; $i++) {
                $result *= $i;
            }
            $calculation = "$num1! = $result";
            $_SESSION['history'][] = $calculation;
        }
    }
}

// Verificar ações específicas
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'save':
            if ($result !== "") {
                $_SESSION['history'][] = "Salvo: $result";
            }
            break;
        case 'get':
            // Mostrar todo o histórico
            $all_results = implode("<br>", $_SESSION['history']);
            break;
        case 'clear':
            $_SESSION['history'] = [];
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calc">
        <form action="" method="GET">
            <label for="" class="texto-calc">Calculadora PHP</label>
            <div class="numeros">
                <label class="num1" for="">Número 1</label>
                <input class="num" type="number" name="num1">
                <select class="op" name="op">
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                    <option value="!">!</option>
                    <option value="^">^</option>
                </select>
                <label class="num2" for="num2">Número 2</label>
                <input class="num" type="number" name="num2">
            </div>
            <button class="enviar" type="submit">Calcular</button>
            <div class="mostrar mostrar-calculo">
                <?php echo htmlspecialchars($result); ?>
            </div>
            <button class="enviar salvar" type="submit" name="action" value="save">Salvar</button>
            <button class="enviar pegar" type="submit" name="action" value="get">Pegar valores</button>
            <button class="enviar apagar" type="submit" name="action" value="clear">Apagar histórico</button>
            <div class="texto-hist">Histórico</div>
            <div class="mostrar mostrar-hist">
                <?php
                if ($all_results) {
                    echo $all_results; 
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
