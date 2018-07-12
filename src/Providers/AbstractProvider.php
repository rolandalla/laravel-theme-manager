<?php

namespace Roland\Theme\Providers;

class AbstractProvider
{
    /**
     * Add more locations and namespaces.
     *
     * @param string $path
     */
    protected function addLocation($path)
    {
        view()->addLocation($path);
        view()->addNamespace('Theme', $path);
    }
}
