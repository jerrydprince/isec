<?php

namespace App\Core;

/**
 * Route Filter Middleware Blueprint
 */
abstract class Middleware {
    /**
     * Intercept and filter the current request / response state
     */
    abstract public function execute(Request $request, Response $response): void;
}
