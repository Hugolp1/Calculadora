<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

$result = "";
if (isset($_GET['num1']) && isset($_GET['op'])) {
    $num1 = (float)$_GET['num1']; 
    $op = $_GET['op'];

    if ($op !== '!') {
        if (isset($_GET['num2'])) {
            $num2 = (float)$_GET['num2'];
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
                        $result = "Erro: Divisão por zero";
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
        } else {
            $result = "Por favor, insira o segundo número.";
        }
    } else {
        if ($num1 < 0) {
            $result = "Fatorial de número negativo não é possível";
        } else {
            $result = 1;
            for ($i = 2; i <= $num1; $i++) {
                $result *= $i;
            }
        }
    }

    $calculation = "$num1 $op";
    if ($op !== '!') {
        $calculation .= " $num2 = $result";
    } else {
        $calculation .= " = $result";
    }
    $_SESSION['history'][] = $calculation;
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'save':
            if ($result !== "") {
                $_SESSION['history'][] = "Salvo: $result";
            }
            break;
        case 'get':
            if (!empty($_SESSION['history'])) {
                $result = end($_SESSION['history']); 
            }
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
                <label class="num1" for="">Numero 1</label>
                <input class="num" type="number" name="num1" id="num1">
                <select class="op" name="op" id="op">
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                    <option value="!">!</option>
                    <option value="^">^</option>
                </select>
                <label class="num2" for="num2">Numero 2</label>
                <input class="num" type="number" name="num2" id="num2">
            </div>
            <button class="enviar" type="submit">Calcular</button>
            <div class="mostrar mostrar-calculo">
                <?php echo htmlspecialchars($result); ?>
            </div>
            <button class="enviar salvar" type="submit" name="action" value="save">Salvar</button>
            <button class="enviar pegar" type="submit" name="action" value="get">Pegar valores</button>
            <button class="enviar m" type="submit">M</button>
            <button class="enviar apagar" type="submit" name="action" value="clear">Apagar histórico</button>
            <div class="texto-hist">Histórico</div>
            <div class="mostrar mostrar-hist">
                <?php
                if (isset($result)) {
                    echo htmlspecialchars($result); 
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
