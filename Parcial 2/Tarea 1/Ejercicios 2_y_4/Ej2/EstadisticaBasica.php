<?php
declare(strict_types=1);
require_once 'Estadistica.php';

class EstadisticaBasica extends Estadistica {

    public function calcularMedia(array $datos): float {
        return array_sum($datos) / count($datos);
    }

    public function calcularMediana(array $datos): float {
        sort($datos);
        $n = count($datos);
        $medio = intdiv($n, 2);
        return $n % 2 === 0
            ? ($datos[$medio - 1] + $datos[$medio]) / 2
            : $datos[$medio];
    }

    public function calcularModa(array $datos): array {
        $frecuencias = array_count_values($datos);
        $max = max($frecuencias);
        return array_keys($frecuencias, $max);
    }

    public function generarInforme(array $conjuntos): array {
        $informe = [];
        foreach ($conjuntos as $nombre => $datos) {
            $informe[$nombre] = [
                'media' => $this->calcularMedia($datos),
                'mediana' => $this->calcularMediana($datos),
                'moda' => $this->calcularModa($datos),
            ];
        }
        return $informe;
    }
}
?>
