<?php
declare(strict_types=1);
require_once 'MatrizAbstracta.php';

class Matriz extends MatrizAbstracta {

    public function multiplicar(array $otra): array {
        $resultado = [];
        $n = count($this->matriz);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $suma = 0;
                for ($k = 0; $k < $n; $k++) {
                    $suma += $this->matriz[$i][$k] * $otra[$k][$j];
                }
                $resultado[$i][$j] = $suma;
            }
        }
        return $resultado;
    }

    public function determinante(): float {
        $a = $this->matriz;
        if (count($a) === 2) {
            return ($a[0][0] * $a[1][1]) - ($a[0][1] * $a[1][0]);
        }
        throw new Exception("Determinante solo soportado para matrices 2x2.");
    }

    public function inversa(): ?array {
        $det = $this->determinante();
        if ($det === 0.0) return null;

        $a = $this->matriz;
        return [
            [ $a[1][1] / $det, -$a[0][1] / $det ],
            [ -$a[1][0] / $det, $a[0][0] / $det ]
        ];
    }
}
?>

