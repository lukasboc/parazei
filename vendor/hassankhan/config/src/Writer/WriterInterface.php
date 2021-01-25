<?php

namespace Noodlehaus\Writer;

use Noodlehaus\Exception\WriteException;

/**
 * Config file parser interface.
 *
 * @package    Config
 * @author     Jesus A. Domingo <jesus.domingo@gmail.com>
 * @author     Hassan Khan <contact@hassankhan.me>
 * @author     Filip Š <projects@filips.si>
 * @author     Mark de Groot <mail@markdegroot.nl>
 * @link       https://github.com/noodlehaus/config
 * @license    MIT
 */
interface WriterInterface
{
    /**
     * Returns an array of allowed file extensions for this writer.
     *
     * @return array
     */
    public static function getSupportedExtensions();

    /**
     * Writes a configuration from `$config` to `$filename`.
     *
     * @param array $config
     * @param string $filename
     *
     * @return array
     * @throws WriteException if the data could not be written to the file
     *
     */
    public function toFile($config, $filename);

    /**
     * Writes a configuration from `$config` to a string.
     *
     * @param array $config
     * @param bool $pretty
     *
     * @return array
     */
    public function toString($config, $pretty = true);
}
