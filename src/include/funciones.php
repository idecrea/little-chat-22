<?php 

//-----------------------------------------------------
// Funciones
//-----------------------------------------------------

    function get_str_request(string $param, string $default = ''): string
    {
        return isset($_REQUEST[$param]) ? $_REQUEST[$param] : $default;
    }
    /**
     * Método que valida parámetros del request
     * @param {string} - Texto a validar
     * @return {int}
     */
    function get_int_request(string $param, int $default = 0): int
    {
        return isset($_REQUEST[$param]) ? (int) $_REQUEST[$param] : $default;
    }
    