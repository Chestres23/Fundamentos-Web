<?php
declare(strict_types=1);

interface OperacionesMatriz {
    public function multiplicar(array $otra): array;
    public function inversa(): ?array;
    public function determinante(): float;
}

abstract class MatrizAbstracta implements OperacionesMatriz {
    protected $matriz; // quitamos tipado de propiedad

    public function __construct(array $matriz) {
        $this->matriz = $matriz;
    }
}
?>
