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
        <form action="">
            <label for="" class="texto-calc">Calculadora PHP</label>
            <div class="numeros">
                <label class="num1" for="">Numero 1</label>
                <input class="num" type="number" name="num1" id="num1">
                <select class="op" name="op" id="op">
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                </select>
                <label class="num2" for="num2">Numero 2</label>
                <input class="num" type="number" name="num2" id="num2">
            </div>
            <button class="enviar" type="submit">Calcular</button>
        </form>
    </div>
</body>
</html>