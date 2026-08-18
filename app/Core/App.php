<?php
// Trigger deployment

namespace App\Core;

/**
 * Main Application Bootstrapper
 */
class App {
    public static App $app;
    public static string $ROOT_DIR;
    
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct(string $rootDir) {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
    }

    /**
     * Start the application and resolve routes
     */
    public function run(): void {
        try {
            $this->router->resolve($this->request, $this->response);
        } catch (\Exception $e) {
            $this->response->setStatusCode(500);
            View::render('errors/500', [
                'title' => 'Internal Server Error',
                'exception' => $e
            ]);
        }
    }
}
