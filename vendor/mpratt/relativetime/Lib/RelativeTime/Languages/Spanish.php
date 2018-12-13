<?php

namespace RelativeTime\Languages;

class Spanish extends \RelativeTime\Adapters\Language
{
    protected $strings = array(
        'now' => 'justo ahora',
        'ago' => 'hace %s',
        'left' => 'faltan %s',
        'seconds' => array(
            'plural' => '%d segundos',
            'singular' => '%d segundo',
        ),
        'minutes' => array(
            'plural' => '%d minutos',
            'singular' => '%d minuto',
        ),
        'hours' => array(
            'plural' => '%d horas',
            'singular' => '%d hora',
        ),
        'days' => array(
            'plural' => '%d dias',
            'singular' => '%d dia',
        ),
        'months' => array(
            'plural' => '%d meses',
            'singular' => '%d mes',
        ),
        'years' => array(
            'plural' => '%d años',
            'singular' => '%d año',
        ),
    );
}

?>
