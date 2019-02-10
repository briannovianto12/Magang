<?php

namespace Bromo\Theme;

use Illuminate\Support\Facades\Config;

class Themes
{
    /**
     * Contains current activated theme code
     *
     * @var string
     */
    protected $activeTheme = null;

    /**
     * Contains all themes
     *
     * @var array
     */
    protected $themes = [];

    /**
     * Contains laravel default view paths
     *
     * @var array
     */
    protected $laravelViewsPath;

    /**
     * Contains default theme code
     *
     * @var string
     */
    protected $defaultThemeCode = 'default';


    /**
     * Create a new Themes instance.
     *
     * @throws Exceptions\ThemeNotFound
     * @return void
     */
    public function __construct()
    {
        $this->laravelViewsPath = Config::get('view.paths');

        $this->defaultThemeCode = Config::get('themes.default', null);

        $this->loadThemes();
    }

    /**
     * Prepare all themes
     *
     * @return void
     * @throws Exceptions\ThemeNotFound
     */
    public function loadThemes()
    {
        $parentThemes = [];
        $themes = config('themes.themes', []);

        foreach ($themes as $code => $data) {
            $this->themes[] = new Theme(
                $code,
                isset($data['name']) ? $data['name'] : '',
                isset($data['assets_path']) ? $data['assets_path'] : '',
                isset($data['views_path']) ? $data['views_path'] : ''
            );

            if (isset($data['parent']) && $data['parent']) {
                $parentThemes[$code] = $data['parent'];
            }
        }

        foreach ($parentThemes as $childCode => $parentCode) {
            $child = $this->find($childCode);

            if ($this->exists($parentCode)) {
                $parent = $this->find($parentCode);
            } else {
                $parent = new Theme($parentCode);
            }

            $child->setParent($parent);
        }
    }

    /**
     * Find a theme by it's name
     *
     * @param $themeName
     * @return Theme
     * @throws Exceptions\ThemeNotFound
     */
    public function find(string $themeName)
    {
        foreach ($this->themes as $theme) {
            if ($theme->code == $themeName) {
                return $theme;
            }
        }

        throw new Exceptions\ThemeNotFound($themeName);
    }

    /**
     * Check if specified exists
     *
     * @param $themeName
     * @return bool
     */
    public function exists($themeName)
    {
        foreach ($this->themes as $theme) {
            if ($theme->code == $themeName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return list of registered themes
     *
     * @return array
     */
    public function all()
    {
        return $this->themes;
    }

    /**
     * Enable theme
     *
     * @param $themeName
     * @return Theme
     * @throws Exceptions\ThemeNotFound
     */
    public function set($themeName)
    {
        if ($this->exists($themeName)) {
            $theme = $this->find($themeName);
        } else {
            $theme = new Theme($themeName);
        }

        $this->activeTheme = $theme;

        $paths = $theme->getViewPaths();

        foreach ($this->laravelViewsPath as $path) {
            if (!in_array($path, $paths)) {
                $paths[] = $path;
            }
        }

        Config::set('view.paths', $paths);

        $themeViewFinder = app('view.finder');
        $themeViewFinder->setPaths($paths);

        return $theme;
    }

    /**
     * Get current theme's name
     *
     * @return string
     */
    public function getName()
    {
        return $this->current() ? $this->current()->name : '';
    }

    /**
     * Get current theme
     *
     * @return string
     */
    public function current()
    {
        return $this->activeTheme ? $this->activeTheme : null;
    }

    /**
     * Original view paths defined in config.view.php
     *
     * @return array
     */
    public function getLaravelViewPaths()
    {
        return $this->laravelViewsPath;
    }

    /**
     * Return asset url of current theme
     *
     * @param $filename
     * @param null $secure
     * @return string
     */
    public function url($filename, $secure = null)
    {
        if (!$this->current()) {
            return asset($filename, $secure);
        }

        return $this->current()->url($filename, $secure);
    }
}