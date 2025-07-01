<?php
declare(strict_types=1); // Habilita el tipado estricto en PHP

// Clase abstracta que define la estructura de cualquier sistema de ecuaciones
abstract class SistemaEcuaciones {
    // Método abstracto que calculará el resultado del sistema
    abstract public function calcularResultado(array $sistema): array;

    // Método abstracto que validará si el sistema está bien estructurado
    abstract public function validarConsistencia(array $sistema): bool;
}

// Clase concreta que extiende la clase abstracta y resuelve un sistema 2x2
class SistemaLineal extends SistemaEcuaciones {

    // Valida que cada variable tenga exactamente dos coeficientes
    public function validarConsistencia(array $sistema): bool {
        foreach ($sistema as $valores) {
            if (count($valores) !== 2) {
                return false;
            }
        }
        return true;
    }

    // Aplica el método de sustitución para resolver un sistema 2x2
    public function calcularResultado(array $sistema): array {
        // Extraemos los coeficientes del sistema
        $a1 = $sistema['x'][0];  // coeficiente de x en la ecuación 1
        $b1 = $sistema['y'][0];  // coeficiente de y en la ecuación 1
        $c1 = $sistema['ind'][0]; // término independiente de la ecuación 1

        $a2 = $sistema['x'][1];  // coeficiente de x en la ecuación 2
        $b2 = $sistema['y'][1];  // coeficiente de y en la ecuación 2
        $c2 = $sistema['ind'][1]; // término independiente de la ecuación 2

        // Despejamos y y sustituimos
        $y = ($c1 - ($a1 * $c2 / $a2)) / ($b1 - ($a1 * $b2 / $a2));

        // Sustituimos y en la segunda ecuación para hallar x
        $x = ($c2 - $b2 * $y) / $a2;

        // Retornamos un array asociativo con las soluciones
        return ['x' => $x, 'y' => $y];
    }
}

// Función externa que permite resolver el sistema usando la clase SistemaLineal
function resolverSistema(array $sistema): array {
    $sl = new SistemaLineal();

    // Validamos el sistema antes de intentar resolverlo
    if ($sl->validarConsistencia($sistema)) {
        return $sl->calcularResultado($sistema);
    } else {
        return ['error' => 'Ecuaciones inconsistentes'];
    }
}

// 🔽 PRUEBA DEL SISTEMA 🔽

// Sistema de ejemplo:
// Ecuación 1: 2x + y = 8
// Ecuación 2: x - y = 2
$ecuaciones = [
    'x'   => [2, 1],   // coeficientes de x en las ecuaciones 1 y 2
    'y'   => [1, -1],  // coeficientes de y en las ecuaciones 1 y 2
    'ind' => [8, 2]    // términos independientes de las ecuaciones 1 y 2
];

// Llamamos a la función que resuelve el sistema
$resultado = resolverSistema($ecuaciones);

// Mostramos los resultados
echo "Resultado del sistema:\n";
print_r($resultado);

?>
