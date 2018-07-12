<?php

namespace Roland\Theme\Contracts;

interface Factory
{
    /**
     * Get a theme provider implementation.
     *
     * @param string $driver
     *
     * @return \Roland\Theme\Contracts\Provider
     */
    public function driver($driver = null);
}
