<?php
// Calculadora no terminal em PHP

echo "=== CALCULADORA SIMPLES ===\n";
echo "Digite o primeiro número: ";
$num1 = trim(fgets(STDIN));

echo "Digite o operador (+, -, *, /): ";
$operador = trim(fgets(STDIN));

echo "Digite o segundo número: ";
$num2 = trim(fgets(STDIN));

$resultado = 0;

switch ($operador) {
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
        if ($num2 != 0) {
            $resultado = $num1 / $num2;
        } else {
            echo "Erro: divisão por zero não é permitida!\n";
            exit;
        }
        break;
    default:
        echo "Operador inválido!\n";
        exit;
}

echo "Resultado: $num1 $operador $num2 = $resultado\n";
?>
