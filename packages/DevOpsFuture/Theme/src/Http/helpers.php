<?php

use DevOpsFuture\Theme\ViewRenderEventManager;

if (! function_exists('themes')) {
    function themes()
    {
        return app()->make('themes');
    }
}

if (! function_exists('devopsfuture_asset')) {
    function devopsfuture_asset($path, $secure = null)
    {
        return themes()->url($path, $secure);
    }
}

if (! function_exists('view_render_event')) {
    function view_render_event($eventName, $params = null)
    {
        app()->singleton(ViewRenderEventManager::class);

        $viewEventManager = app()->make(ViewRenderEventManager::class);

        $viewEventManager->handleRenderEvent($eventName, $params);

        return $viewEventManager->render();
    }
}
