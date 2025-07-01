<?php
declare(strict_types=1);

interface OperacionesEstadisticas {
    public function calcularMedia(array $datos): float;
    public function calcularMediana(array $datos): float;
    public function calcularModa(array $datos): array;
}

abstract class Estadistica implements OperacionesEstadisticas {
    abstract public function generarInforme(array $conjuntos): array;
}
?>

