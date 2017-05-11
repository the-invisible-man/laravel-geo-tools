<?php

namespace InvisibleMan\Geo\Contracts;

/**
 * Interface ServiceFactory
 *
 * @package InvisibleMan\Geo\Contracts
 * @author  Carlos Granados <granados.carlos91@gmail.com>
 */
interface ServiceFactory
{
    public function service(string $name);
}
