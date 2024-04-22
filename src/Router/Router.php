<?php

// Router class to handle HTTP requests
class Router {
    // Stores the handlers for each route
    private $handlers = [];
    // Stores the handler for not found routes
    private $notFoundHandler;

    /**
     * Adds a GET route
     *
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    public function get($path, $handler) {
        $this->addHandler('GET', $path, $handler);
    }

    /**
     * Adds a POST route
     *
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    public function post($path, $handler) {
        $this->addHandler('POST', $path, $handler);
    }

    /**
     * Adds a route
     *
     * @param string $method The HTTP method
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    private function addHandler($method, $path, $handler) {
        $this->handlers[$method][$path] = $handler;
    }

    /**
     * Sets the handler for not found routes
     *
     * @param callable $handler The handler for not found routes
     */
    public function setNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }

    /**
     * Dispatches the request to the appropriate handler
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $handler = $this->handlers[$method][$path] ?? null;

        if ($handler) {
            call_user_func($handler, $this);
        } elseif ($this->notFoundHandler) {
            call_user_func($this->notFoundHandler, $this);
        } else {
            header("HTTP/1.0 error Not Found");
            require __DIR__ . '/../views/notfound.php';
        }
    }
}