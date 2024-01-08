<?php

namespace App\Helpers;

class SweetAlert2
{

    /**
     * Retorna un arreglo para ejecutar una alerta con SweetAlert2
     */
    private function SweetAlert2(String $text, String $title, String $icon)
    {
        return [
            'SweetAlert2' => [
                'icon'  => "{$icon}",
                'title' => "{$title}",
                'text'  => "{$text}"
            ]
        ];
    }

    public static function success(String $text)
    {
        return (new Self)->SweetAlert2($text, 'Correcto', 'success');
    }

    public static function info(String $text)
    {
        return (new Self)->SweetAlert2($text, 'Atención', 'info');
    }

    public static function warning(String $text)
    {
        return (new Self)->SweetAlert2($text, 'Atención', 'warning');
    }

    public static function error(String $text)
    {
        return (new Self)->SweetAlert2($text, 'Error', 'error');
    }
}
