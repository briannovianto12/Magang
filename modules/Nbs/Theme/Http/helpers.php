<?php

use Nbs\Theme\ViewRenderEventManager;

if (!function_exists('themes')) {
    function themes()
    {
        return app()->make('themes');
    }
}

if (!function_exists('nbs_helper')) {

    function nbs_helper()
    {
        return app()->make('helper');
    }
}

if (!function_exists('nbs_asset')) {
    function nbs_asset($path)
    {
        $secure = config('themes.app_secure');

        return themes()->url($path, $secure);
    }
}

if (!function_exists('view_render_event')) {
    function view_render_event($eventName, $params = null)
    {
        app()->singleton(ViewRenderEventManager::class);

        $viewEventManager = app()->make(ViewRenderEventManager::class);

        $viewEventManager->handleRenderEvent($eventName, $params);

        return $viewEventManager->render();
    }
}