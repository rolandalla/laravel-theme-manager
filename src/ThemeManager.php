<?php

namespace Roland\Theme;

use Illuminate\Support\Manager;
use InvalidArgumentException;
use Roland\Theme\Providers\FileProvider;

class ThemeManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param string $driver
     *
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Roland\Theme\Providers\AbstractProvider
     */
    protected function createFileDriver()
    {
        $config = $this->app['config']['themes'];

        return $this->buildProvider(FileProvider::class, $config);
    }

    /**
     * Build a theme provider instance.
     *
     * @param string $provider
     *
     * @return \Roland\Theme\Providers\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider($config);
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $config = $this->app['config']['themes.driver'];

        if ($config) {
            return $config;
        }

        throw new InvalidArgumentException('No Theme driver was specified.');
    }
}
