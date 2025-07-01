<?php
declare(strict_types=1);
require_once 'EstadisticaBasica.php';

$datos = [
    'grupo1' => [1, 2, 2, 3, 4],
    'grupo2' => [10, 20, 30, 40],
    'grupo3' => [7, 7, 8, 9, 10]
];

$estadistica = new EstadisticaBasica();
$resultados = $estadistica->generarInforme($datos);

echo "📊 Resultados Estadísticos:\n";
foreach ($resultados as $grupo => $estadisticas) {
    echo "Grupo: $grupo\n";
    echo "  Media: {$estadisticas['media']}\n";
    echo "  Mediana: {$estadisticas['mediana']}\n";
    echo "  Moda: " . implode(', ', $estadisticas['moda']) . "\n\n";
}
?>
