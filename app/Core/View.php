<?php

namespace App\Core;

/**
 * Compiles Views and Embeds them in Layout templates
 */
class View {
    public static string $layout = 'main';

    /**
     * Set the active master template layout
     */
    public static function setLayout(string $layout): void {
        self::$layout = $layout;
    }

    /**
     * Compile view path and wrap in layout template
     */
    public static function render(string $view, array $params = []): string {
        $viewContent = self::renderViewOnly($view, $params);
        
        if (self::$layout === 'none') {
            echo $viewContent;
            return $viewContent;
        }

        $layoutContent = self::renderLayoutOnly($params);
        $output = str_replace('{{content}}', $viewContent, $layoutContent);
        echo $output;
        return $output;
    }

    /**
     * Renders view-specific content inside dynamic buffer
     */
    protected static function renderViewOnly(string $view, array $params = []): string {
        // Extract variables to local scope
        extract($params);
        
        ob_start();
        $viewFile = App::$ROOT_DIR . "/app/views/" . $view . ".php";
        
        if (file_exists($viewFile)) {
            include_once $viewFile;
        } else {
            echo "<p>View file <code>{$view}</code> not found.</p>";
        }
        
        return ob_get_clean();
    }

    /**
     * Renders container layout template
     */
    protected static function renderLayoutOnly(array $params = []): string {
        extract($params);
        
        ob_start();
        $layoutFile = App::$ROOT_DIR . "/app/views/layouts/" . self::$layout . ".php";
        
        if (file_exists($layoutFile)) {
            include_once $layoutFile;
        } else {
            echo "<p>Layout template <code>" . self::$layout . "</code> not found.</p> {{content}}";
        }
        
        return ob_get_clean();
    }
}
