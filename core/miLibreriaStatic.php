<?php

/**
 * @author Véronique
 * @since 19/10/2025
 * 
 * Librería con funciones matemáticas creado una clase
 */
class miLibreriaStatic {

    /**
     * Suma de dos números
     * @param float $a Primer número
     * @param float $b Segundo número
     * @return float Resultado de la suma
     */
    public static function sumar($a, $b) {
        return $a + $b;
    }

    /**
     * Resta dos números
     * @param float $a Primer número
     * @param float $b Segundo número
     * @return float Resultado de la resta
     */
    public static function restar($a, $b) {
        return $a - $b;
    }

    /**
     * Función para validar una pregunta de seguridad con valores predefinidos.
     *
     * @param string $respuestaSeguridad Valor introducido por el usuario.
     * @param array $aValoresValidos Lista de respuestas válidas permitidas.
     * @param bool $obligatorio Indica si el campo es obligatorio (1 si true, 0 si false).
     * @return string|null Devuelve mensaje de error si hay problema, o null si es válido.
     */
    public static function comprobarPreguntaSeguridad($respuestaSeguridad, $aValoresValidos, $obligatorio) {
        $mensajeError = null;

        // Elimina espacios en blanco al principio y al final
        $respuestaSeguridad = trim($respuestaSeguridad);

        // Si el campo es obligatorio y está vacío
        if ($obligatorio == 1 && empty($respuestaSeguridad)) {
            $mensajeError = "La pregunta de seguridad no puede estar vacía.";
        }

        // Si no está vacío y no coincide con ninguno de los valores válidos
        if (!empty($respuestaSeguridad) && !in_array($respuestaSeguridad, $aValoresValidos)) {
            $mensajeError = "La respuesta de seguridad es incorrecta.";
        }

        // Si todo está correcto
        return $mensajeError;
    }

    public static function comprobarFloatMonetarioES($float, $obligatorio = 0) {
        $mensajeError = null;
        if ($obligatorio == 1 && $float != '0') {
            $mensajeError = self::comprobarNoVacio($float);
        }

        if (($obligatorio == 0 && $float != null) || ($obligatorio == 1 && empty($mensajeError))) {//COMPROBAMOS QUE SI ES OPCIONAL, NO ESTÉ VACÍO Y SI ES OBLIGATORIO QUE NO HAYA GUARDADO UN MENSAJE DE ERROR ANTERIOR (QUE EL CAMPO NO ESTÉ VACÍO)   
            if (!preg_match('/^[0-9]+(,[0-9]+)?$/', $float)) {//se comprueba si es un decimal con coma
                $mensajeError = "Formato decimal incorrecto";
            }
        }
        return $mensajeError;
    }

    public static function comprobarFloatMonetarioES2($float, $max = PHP_FLOAT_MAX, $min = -PHP_FLOAT_MAX, $obligatorio = 0) {
        $mensajeError = null;

        if ($obligatorio == 1 && $float !== '0') {
            $mensajeError = self::comprobarNoVacio($float);
        }
        if (($obligatorio == 0 && $float !== null && $float !== '') || ($obligatorio == 1 && empty($mensajeError))) {

            if (!preg_match('/^-?[0-9]+(,[0-9]+)?$/', $float)) {
                $mensajeError = "Formato decimal incorrecto";
            } else {
                //se convierte a float con punto para la base de datos
                $floatConvertido = str_replace(',', '.', $float);

                if ($floatConvertido > $max) {
                   $mensajeError .= "El número no puede ser mayor que " . $max . ".";
                }
                if ($floatConvertido < $min) {
                    $mensajeError .= "El número no puede ser menor que " . $min . ".";
                }
            }
        }
        return $mensajeError;
    }

    public static function comprobarNoVacio($cadena) {
        $mensajeError = null;
        $cadena = htmlspecialchars(strip_tags(trim($cadena)));

        if (empty($cadena)) {
            $mensajeError = " Campo vacío.";
        }
        return $mensajeError;
    }

    public static function comprobarAlfabeticoMayuscula($cadena, $maxTamanio, $minTamanio, $obligatorio) {  //AÑADIDOS VALORES POR DEFECTO Y MEJORADA LA RESPUESTA
        // Patrón para campos de solo texto
        $patron_texto = "/^[A-ZÁÉÍÓÚÄËÏÖÜÀÈÌÒÙÑ\s]+$/";
        $cadena = htmlspecialchars(strip_tags(trim((string) $cadena)));
        $mensajeError = null;

        //Si es olbigatorio se comprueba si está vacío, si no es obligatorio, no es necesario
        if ($obligatorio == 1) {
            $mensajeError = self::comprobarNoVacio($cadena);
        }

        //Comprobación de que la cadena introducida coincide con la sintaxis permitida del patrón
        if (!preg_match($patron_texto, $cadena) && !empty($cadena)) {
            $mensajeError = " Solo se admiten letras en mayúsculas.";
        }
        $mensajeError .= self::comprobarMaxTamanio($cadena, $maxTamanio);
        $mensajeError .= self::comprobarMinTamanio($cadena, $minTamanio);
        return $mensajeError;
    }

    public static function comprobarMaxTamanio($cadena, $tamanio) {
        $mensajeError = null;
        if (strlen($cadena) > $tamanio) {
            $mensajeError = " El tamaño máximo es de " . $tamanio . " caracteres.";
        }
        return $mensajeError;
    }

    public static function comprobarMinTamanio($cadena, $tamanio) {
        $mensajeError = null;
        if (strlen($cadena) < $tamanio && strlen($cadena) > 0) { //AÑADIDA SEGUNDA COMPROBACIÓN. Para que cuando el campo esté vacío no muestre este mensaje, sólo cuando haya mínimo 1 caracter para advertir del tamaño mínimo
            $mensajeError = " El tamaño mínimo es de " . $tamanio . " caracteres.";
        }
        return $mensajeError;
    }
}

?>