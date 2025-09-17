<?php
class funcoes {
    public function dtNasc($vlr, $tipo){
        $rst = ""; // garante que a variável exista

        switch ($tipo) {
            case 1:
                $rst = implode("-", array_reverse(explode("/", $vlr))); 
                break;

            case 2:
                $rst = implode("/", array_reverse(explode("-", $vlr)));
                break;

            default:
                $rst = $vlr; // retorna valor original se tipo não for 1 nem 2
        }

        return $rst;
    }
}
?>
