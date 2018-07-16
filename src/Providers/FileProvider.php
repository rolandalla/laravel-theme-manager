<?php

namespace Roland\Theme\Providers;

use Exception;
use Roland\Theme\Contracts\Provider;

class FileProvider extends AbstractProvider implements Provider
{
    public $driver;
    public $theme;
    public $path;

    public function __construct($config)
    {
        $this->theme = app('request')->input('theme', $config['theme']);
        $this->path = $config['path'];
    }

    /**
     * Display the view.
     *
     * @param array $view
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function view($view = [], $data = [])
    {
        if (!$this->exists($this->theme)) {
            throw new Exception('The theme '.'"'.$this->theme.'"'.' does not exist.');
        }

        $this->addLocation($this->path.'/'.$this->theme);

        return view()->first($view, $data);
    }

    /**
     * Use a theme as the current theme.
     *
     * @param string $theme
     *
     * @throws \Exception
     *
     * @return void
     */
    public function use($theme)
    {
        if (!$this->exists($theme)) {
            throw new Exception('The theme '.'"'.$theme.'"'.' does not exist.');
        }

        $this->theme = $theme;

        return $this;
    }

    /**
     * Set a theme as the current theme.
     *
     * @param string $theme
     *
     * @throws \Exception
     *
     * @return void
     */
    public function set($theme)
    {
        if (!$this->exists($theme)) {
            throw new Exception('The theme '.'"'.$theme.'"'.' does not exist.');
        }
        $this->theme = $theme;
        \Config::set('themes.theme', $theme);
        $this->addLocation($this->path.'/'.$this->theme);
        return $this;
    }
    public function themes_path($filename = null)
    {
        return $filename ? $this->path . '/' . $filename : $this->path;
    }
    // Scans theme folders for theme.json files and returns an array of themes
    public function all()
    {
        $themes = [];
        foreach (glob($this->themes_path('*'), GLOB_ONLYDIR) as $themeFolder) {
            $themeFolder = realpath($themeFolder);
            if (file_exists($jsonFilename = $themeFolder . '/' . 'theme.json')) {
                $folders = explode(DIRECTORY_SEPARATOR, $themeFolder);
                $themeName = end($folders);
                // default theme settings
                $defaults = [
                    'name' => $themeName,
                    'asset-path' => $themeName,
                    'extends' => null,
                ];
                // If theme.json is not an empty file parse json values
                $json = file_get_contents($jsonFilename);
                if ($json !== "") {
                    $data = json_decode($json, true);
                    if ($data === null) {
                        throw new \Exception("Invalid theme.json file at [$themeFolder]");
                    }
                } else {
                    $data = [];
                }
                // We already know views-path since we have scaned folders.
                // we will overide this setting if exists
                $data['views-path'] = $themeName;
                $themes[] = array_merge($defaults, $data);
            }
        }
        return $themes;
    }

    /**
     * Check whether a theme exists or not.
     *
     * @param string $theme
     *
     * @return bool
     */
    public function exists($theme)
    {
        $themePath = $this->path.'/'.$theme;
        $themeInfoPath = $themePath.'/theme.json';

        if (is_dir($themePath) && file_exists($themeInfoPath)) {
            return true;
        }

        return false;
    }

    /**
     * Return theme information.
     *
     * @param string $theme
     *
     * @return mixed
     */
    public function info($theme = null)
    {
        if ($theme == null && $this->exists($this->theme)) {
            $themePath = $this->path.'/'.$this->theme;
            $themeInfoPath = $themePath.'/theme.json';

            return json_decode(file_get_contents($themeInfoPath), true);
        }

        if ($theme != null && $this->exists($theme)) {
            $themePath = $this->path.'/'.$theme;
            $themeInfoPath = $themePath.'/theme.json';

            return json_decode(file_get_contents($themeInfoPath), true);
        }

        throw new Exception('The theme '.'"'.$theme.'"'.' does not exist.');
    }
}
