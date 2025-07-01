<?php
declare(strict_types=1); // Activa el modo estricto de tipos para mayor seguridad en PHP.

// Definición de una clase abstracta para polinomios
abstract class PolinomioAbstracto {
    // Método abstracto que debe implementar cualquier subclase
    // Evalúa el polinomio en el valor x.
    abstract public function evaluar(float $x): float;

    // Método abstracto que debe implementar cualquier subclase
    // Devuelve un nuevo polinomio que representa la derivada.
    abstract public function derivada(): Polinomio;
}

// Clase concreta que implementa PolinomioAbstracto
class Polinomio extends PolinomioAbstracto {
    // Almacena los términos del polinomio como [grado => coeficiente]
    private array $terminos;

    // Constructor: recibe opcionalmente un arreglo de términos
    public function __construct(array $terminos = []) {
        $this->terminos = $terminos;
    }

    // Devuelve el arreglo de términos del polinomio
    public function getTerminos(): array {
        return $this->terminos;
    }

    // Evalúa el polinomio en un valor x
    public function evaluar(float $x): float {
        $resultado = 0.0;

        // Para cada término (grado, coeficiente), calcula coeficiente * x^grado
        foreach ($this->terminos as $grado => $coeficiente) {
            $resultado += $coeficiente * ($x ** $grado);
        }
        return $resultado;
    }

    // Calcula y devuelve la derivada del polinomio como un nuevo objeto Polinomio
    public function derivada(): Polinomio {
        $derivada = [];

        // Derivar: la derivada de a*x^n es n*a*x^(n-1)
        foreach ($this->terminos as $grado => $coeficiente) {
            if ($grado > 0) {
                $derivada[$grado - 1] = $coeficiente * $grado;
            }
        }
        return new Polinomio($derivada);
    }
}

// Función que suma dos polinomios representados como arreglos [grado => coeficiente]
function sumarPolinomios(array $p1, array $p2): array {
    $resultado = $p1;

    // Para cada término en el segundo polinomio
    foreach ($p2 as $grado => $coeficiente) {
        if (isset($resultado[$grado])) {
            // Si ya existe el grado, se suman los coeficientes
            $resultado[$grado] += $coeficiente;
        } else {
            // Si no existe, se añade el nuevo término
            $resultado[$grado] = $coeficiente;
        }
    }

    // Eliminar términos cuyo coeficiente sea prácticamente cero
    foreach ($resultado as $grado => $coef) {
        if (abs($coef) < 1e-10) {
            unset($resultado[$grado]);
        }
    }

    // Ordenar por grado ascendente
    ksort($resultado);
    return $resultado;
}

// Función para leer un polinomio desde la entrada del usuario
// Ejemplo de entrada esperada: 3x^0 + 4x^1 - 5x^2
function leerPolinomio(): array {
    $entrada = readline("Ingresa un polinomio (ejemplo: 3x^0 + 4x^1 - 5x^2): ");
    $terminos = [];

    // Busca todas las coincidencias de términos con patrón coeficiente x^grado
    preg_match_all('/([-+]?\s*\d*\.?\d*)x\^(\d+)/', $entrada, $coincidencias, PREG_SET_ORDER);

    foreach ($coincidencias as $coincidencia) {
        $coef = trim(str_replace(' ', '', $coincidencia[1]));
        $grado = (int) $coincidencia[2];

        // Interpretar coeficientes:
        // Si no hay número explícito, se asume 1 o -1
        if ($coef === '+' || $coef === '') {
            $coef = 1.0;
        } elseif ($coef === '-') {
            $coef = -1.0;
        } else {
            $coef = floatval($coef);
        }

        // Guardar el coeficiente con su respectivo grado
        $terminos[$grado] = $coef;
    }
    return $terminos;
}

// Comienza el programa principal
echo "Manejo de polinomios\n";

echo "Primer polinomio:\n";
// Leer el primer polinomio del usuario
$p1 = new Polinomio(leerPolinomio());

echo "Segundo polinomio:\n";
// Leer el segundo polinomio del usuario
$p2 = new Polinomio(leerPolinomio());

// Leer el valor de x para evaluar los polinomios
$xEval = floatval(readline("Ingresa el valor de x para evaluar los polinomios: "));

// Sumar los dos polinomios y crear un nuevo objeto Polinomio con el resultado
$suma = sumarPolinomios($p1->getTerminos(), $p2->getTerminos());
$polinomioSuma = new Polinomio($suma);

echo "\nResultados:\n";
// Mostrar evaluación del primer polinomio en x
echo "Evaluar primer polinomio en x = $xEval: " . $p1->evaluar($xEval) . "\n";

// Mostrar evaluación del segundo polinomio en x
echo "Evaluar segundo polinomio en x = $xEval: " . $p2->evaluar($xEval) . "\n";

// Mostrar evaluación de la suma de ambos polinomios en x
echo "Evaluar suma de polinomios en x = $xEval: " . $polinomioSuma->evaluar($xEval) . "\n";

// Calcular y mostrar la derivada del primer polinomio evaluada en x
$derivadaP1 = $p1->derivada();
echo "Derivada del primer polinomio evaluada en x = $xEval: " . $derivadaP1->evaluar($xEval) . "\n";
