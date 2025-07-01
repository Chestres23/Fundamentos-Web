<?php
declare(strict_types=1); // Activa el tipado estricto: obliga a usar los tipos correctos

// Clase abstracta que define lo mínimo que debe tener una clase de polinomios
abstract class PolinomioAbstracto {
    // Método que permite evaluar el polinomio en un valor de x
    abstract public function evaluar(float $x): float;

    // Método que devuelve la derivada del polinomio como otro array asociativo
    abstract public function derivada(): array;
}

// Clase concreta que representa un polinomio y hereda de PolinomioAbstracto
class Polinomio extends PolinomioAbstracto {
    private array $terminos; // Almacena el polinomio: [grado => coeficiente]

    // Constructor: recibe un array asociativo y lo guarda en la propiedad $terminos
    public function __construct(array $terminos) {
        $this->terminos = $terminos;
    }

    // Evalúa el polinomio en un valor específico de x
    public function evaluar(float $x): float {
        $resultado = 0.0;

        // Recorremos cada término y aplicamos: coeficiente * x^grado
        foreach ($this->terminos as $grado => $coef) {
            $resultado += $coef * pow($x, (int)$grado);
        }

        return $resultado; // Devolvemos el resultado final
    }

    // Calcula la derivada del polinomio (regla de potencia: n*a*x^(n-1))
    public function derivada(): array {
        $derivada = [];

        // Solo derivamos términos con grado mayor a 0
        foreach ($this->terminos as $grado => $coef) {
            if ((int)$grado > 0) {
                $nuevoGrado = (int)$grado - 1;
                $nuevoCoef = (int)$grado * $coef;
                $derivada[$nuevoGrado] = $nuevoCoef;
            }
        }

        return $derivada; // Devuelve la derivada como nuevo array
    }

    // Método estático: suma dos polinomios representados como arrays asociativos
    public static function sumarPolinomios(array $p1, array $p2): array {
        $suma = $p1;

        // Recorremos cada término de $p2 y lo sumamos al término correspondiente en $p1
        foreach ($p2 as $grado => $coef) {
            if (isset($suma[$grado])) {
                $suma[$grado] += $coef;
            } else {
                $suma[$grado] = $coef;
            }
        }

        // Ordenamos el array de mayor a menor grado para mejor presentación
        krsort($suma);
        return $suma;
    }
}

// 🔽 PRUEBA DEL FUNCIONAMIENTO DEL POLINOMIO 🔽

// Definimos dos polinomios como arrays asociativos
$p1 = [2 => 3, 1 => 4, 0 => 2]; // Representa: 3x² + 4x + 2
$p2 = [2 => 1, 1 => -1, 0 => 3]; // Representa: 1x² - x + 3

// Creamos instancias de la clase Polinomio con los arrays
$polinomio1 = new Polinomio($p1);

// Evaluamos el primer polinomio en x = 2
echo "Evaluación de p1 en x = 2: " . $polinomio1->evaluar(2.0) . "\n";

// Mostramos la derivada de p1
echo "Derivada de p1:\n";
print_r($polinomio1->derivada());

// Sumamos los dos polinomios usando el método estático
echo "Suma de p1 y p2:\n";
print_r(Polinomio::sumarPolinomios($p1, $p2));

?>
