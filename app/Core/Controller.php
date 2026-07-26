<?php

namespace App\Core;

/**
 * Base Controller
 */
abstract class Controller {
    /**
     * Render a dynamic view using View system
     */
    protected function render(string $view, array $params = []): string {
        return View::render($view, $params);
    }

    /**
     * Set a custom master layout
     */
    protected function setLayout(string $layout): void {
        View::setLayout($layout);
    }

    /**
     * Format output response as JSON payload
     */
    protected function json(array $data, int $statusCode = 200): void {
        $response = new Response();
        $response->json($data, $statusCode);
    }
}
