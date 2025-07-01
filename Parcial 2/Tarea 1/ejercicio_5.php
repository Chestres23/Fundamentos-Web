<?php
declare(strict_types=1); // Activa el modo estricto de tipos en PHP

// Clase abstracta que define la interfaz para resolver ecuaciones diferenciales
abstract class EcuacionDiferencial {
    // Método abstracto que debe implementar cualquier subclase
    // Recibe:
    // - callable $funcion → la función f(x, y) de la ecuación diferencial
    // - array $condicionesIniciales → valores iniciales x0, y0
    // - array $parametros → parámetros como h y cantidad de pasos
    // Devuelve:
    // - array con los valores de la solución aproximada
    abstract public function resolverEuler(callable $funcion, array $condicionesIniciales, array $parametros): array;
}

// Clase concreta que implementa el método de Euler numérico
class EulerNumerico extends EcuacionDiferencial {
    public function resolverEuler(callable $funcion, array $condicionesIniciales, array $parametros): array {
        $x = $condicionesIniciales['x0']; // valor inicial de x
        $y = $condicionesIniciales['y0']; // valor inicial de y
        $h = floatval($parametros['h']); // tamaño del paso
        $pasos = intval($parametros['pasos']); // número de pasos a realizar

        $solucion = []; // arreglo para almacenar la solución
        $solucion[$x] = $y; // almacenar la condición inicial

        // Iterar para calcular los valores aproximados
        for ($i = 0; $i < $pasos; $i++) {
            $y = $y + $h * $funcion($x, $y); // Fórmula de Euler: y_{n+1} = y_n + h * f(x_n, y_n)
            $x = $x + $h; // avanzar en x
            $solucion[$x] = $y; // guardar el nuevo valor
        }

        return $solucion; // devolver la solución completa
    }
}

// Función auxiliar que encapsula el uso de la clase EulerNumerico
function aplicarMetodo(callable $funcion, array $condicionesIniciales, array $parametros): array {
    $euler = new EulerNumerico(); // crear objeto del método de Euler
    return $euler->resolverEuler($funcion, $condicionesIniciales, $parametros);
}


echo "Resolución de Ecuaciones Diferenciales - Método de Euler\n";

// Leer la ecuación diferencial ingresada como texto
// Ejemplo de entrada: x + y
$expresion = readline("Ingresa la ecuación diferencial dy/dx = f(x, y), ejemplo: x + y: ");

// Crear la función PHP a partir de la expresión ingresada
// Esto permite que el usuario ingrese cualquier f(x,y)
$funcion = function (float $x, float $y) use ($expresion): float {
    $xEval = $x; // variables auxiliares
    $yEval = $y;

    // Reemplaza x e y en la expresión por las variables PHP $xEval y $yEval
    $exprEval = str_replace(['x', 'y'], ['$xEval', '$yEval'], $expresion);

    // Evalúa dinámicamente la expresión
    return eval("return $exprEval;");
};

// Leer valores iniciales y parámetros del método de Euler
$x0 = floatval(readline("Ingresa el valor inicial x0: "));
$y0 = floatval(readline("Ingresa el valor inicial y0: "));
$xFinal = floatval(readline("Ingresa el valor final de x: "));
$h = floatval(readline("Ingresa el tamaño del paso h: "));

// Verificar que xFinal sea mayor que x0
if ($xFinal <= $x0) {
    echo "Error: el valor final debe ser mayor que x0.\n";
    exit(1);
}

// Calcular la cantidad de pasos (número de iteraciones)
$pasos = intval(($xFinal - $x0) / $h);

if ($pasos <= 0) {
    echo "Error: número de pasos inválido. Revisa los valores.\n";
    exit(1);
}

// Definir las condiciones iniciales y los parámetros en arrays
$condicionesIniciales = ['x0' => $x0, 'y0' => $y0];
$parametros = ['h' => $h, 'pasos' => $pasos];

// Ejecutar el método de Euler
$resultado = aplicarMetodo($funcion, $condicionesIniciales, $parametros);

// Mostrar el resultado al usuario
echo "\nSolución aproximada:\n";
foreach ($resultado as $x => $y) {
    echo "x = " . number_format($x, 4) . " => y ≈ " . number_format($y, 6) . "\n";
}

?>
