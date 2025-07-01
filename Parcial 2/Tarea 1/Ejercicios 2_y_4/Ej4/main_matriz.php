<?php
declare(strict_types=1);
require_once 'Matriz.php';

$matrizOriginal = [
    [4, 7],
    [2, 6]
];

$matriz = new Matriz($matrizOriginal);

echo "🔢 Matriz Original:\n";
print_r($matrizOriginal);

$det = $matriz->determinante();
echo "\nDeterminante: $det\n";

$inversa = $matriz->inversa();
echo "\nMatriz Inversa:\n";
print_r($inversa);

$producto = $matriz->multiplicar($matrizOriginal);
echo "\nMultiplicación de matriz por sí misma:\n";
print_r($producto);
?>

