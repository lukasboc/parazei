<?php

namespace JiraRestApi;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Dumper
{
    public static function dd($x)
    {
        array_map(function ($x) {
            (new self())->dump($x);
        }, func_get_args());
        die(1);
    }

    /**
     * Dump a value with elegance.
     *
     * @param mixed $value
     */
    public static function dump($value)
    {
        if (class_exists(CliDumper::class)) {
            $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();
            $dumper->dump((new VarCloner())->cloneVar($value));
        } else {
            var_dump($value);
        }
    }
}
