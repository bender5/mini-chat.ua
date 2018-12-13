<?php

namespace RelativeTime\Languages;

class German extends \RelativeTime\Adapters\Language
{
    protected $strings = array(
        'now' => 'just now',
        'ago' => 'vor %s',
        'left' => '%s nach',
        'seconds' => array(
            'plural' => '%d Sekunden',
            'singular' => '%d Sekunde',
        ),
        'minutes' => array(
            'plural' => '%d Minuten',
            'singular' => '%d Minute',
        ),
        'hours' => array(
            'plural' => '%d Stunden',
            'singular' => '%d Stunde',
        ),
        'days' => array(
            'plural' => '%d Tage',
            'singular' => '%d Tag',
        ),
        'months' => array(
            'plural' => '%d Monaten',
            'singular' => '%d Monat',
        ),
        'years' => array(
            'plural' => '%d Jahren',
            'singular' => '%d Jahr',
        ),
    );
}

?>
