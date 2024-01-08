<?php

namespace App\Helpers;

class ConsoleLog
{

    /**
     * Retorna un arreglo para ejecutar una alerta con ConsoleLog
     */
    private function ConsoleLog(String $text, String $title)
    {
        return [
            'ConsoleLog' => [
                'title' => "{$title}",
                'text'  => "{$text}"
            ]
        ];
    }

    public static function success(String $text)
    {
        return (new Self)->ConsoleLog($text, 'Correcto');
    }

    public static function info(String $text)
    {
        return (new Self)->ConsoleLog($text, 'Atención');
    }

    public static function warning(String $text)
    {
        return (new Self)->ConsoleLog($text, 'Atención');
    }

    public static function error(String $text)
    {
        return (new Self)->ConsoleLog($text, 'Error');
    }
}
