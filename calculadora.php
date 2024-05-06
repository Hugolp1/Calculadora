<?php
session_start();

if (!isset($_SESSION['historico'])) {
    $_SESSION['historico'] = [];
}

$resultado = "";
$todos_resultados = "";
$num1 = 0;
$op = '+';
$num2 = 0;

if (isset($_GET['num1']) && isset($_GET['op'])) {
    $num1 = isset($_GET['num1']) ? (float)$_GET['num1'] : 0;
    $op = isset($_GET['op']) ? $_GET['op'] : '+';
    $num2 = isset($_GET['num2']) ? (float)$_GET['num2'] : 0;

    if ($op !== '!') {
        if (isset($_GET['num2'])) {
            switch ($op) {
                case '+':
                    $resultado = $num1 + $num2;
                    break;
                case '-':
                    $resultado = $num1 - $num2;
                    break;
                case '*':
                    $resultado = $num1 * $num2;
                    break;
                case '/':
                    if ($num2 == 0) {
                        $resultado = "Erro: Divisão por zero não é permitida.";
                    } else {
                        $resultado = $num1 / $num2;
                    }
                    break;
                case '^':
                    $resultado = pow($num1, $num2);
                    break;
                default:
                    $resultado = "Operação inválida";
                    break;
            }

            $calculo = "$num1 $op $num2 = $resultado";
            $_SESSION['historico'][] = $calculo;

        } else {
            $resultado = "Erro: O segundo número é necessário para esta operação.";
        }
    } else {
        if ($num1 < 0) {
            $resultado = "Erro: Fatorial de número negativo não é possível.";
        } else {
            $resultado = 1;
            for ($i = 2; $i <= $num1; $i++) {
                $resultado *= $i;
            }
            $calculo = "$num1! = $resultado";
            $_SESSION['historico'][] = $calculo;
        }
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'salvar':
            if ($resultado !== "") {
                $_SESSION['historico'][] = $resultado;
            }
            break;
        case 'pegar':
            if (!empty($_SESSION['historico'])) {
                $todos_resultados = end($_SESSION['historico']);
            }
            break;
        case 'apagar':
            $_SESSION['historico'] = [];
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
                <?php echo "$num1 $op $num2 = " . htmlspecialchars($resultado); ?>
            </div>
            <button class="enviar salvar" type="submit" name="action" value="salvar">Salvar</button>
            <button class="enviar pegar" type="submit" name="action" value="pegar">Pegar valores</button>
            <button class="enviar apagar" type="submit" name="action" value="apagar">Apagar histórico</button>
            <div class="texto-hist">Histórico</div>
            <div class="mostrar mostrar-hist">
                <?php
                if ($todos_resultados) {
                    echo $todos_resultados; 
                }
                ?>
            </div>
        </form>
    </div>
</body>
</html>
