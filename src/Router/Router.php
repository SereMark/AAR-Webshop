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
        // Add a handler for GET requests to the specified path
        $this->addHandler('GET', $path, $handler);
    }

    /**
     * Adds a POST route
     *
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    public function post($path, $handler) {
        // Add a handler for POST requests to the specified path
        $this->addHandler('POST', $path, $handler);
    }

    /**
     * Adds a route
     *
     * @param string $method The HTTP method (GET, POST, etc.)
     * @param string $path The route path
     * @param callable $handler The handler for the route
     */
    private function addHandler($method, $path, $handler) {
        // Store the handler for the specified HTTP method and path
        $this->handlers[$method][$path] = $handler;
    }

    /**
     * Sets the handler for not found routes
     *
     * @param callable $handler The handler for not found routes
     */
    public function setNotFoundHandler($handler) {
        // Store the handler for not found routes
        $this->notFoundHandler = $handler;
    }

    /**
     * Dispatches the request to the appropriate handler
     */
    public function dispatch() {
        // Get the current HTTP method (GET, POST, etc.)
        $method = $_SERVER['REQUEST_METHOD'];
        // Get the current request URI path
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Find the handler for the current method and path
        $handler = $this->handlers[$method][$path] ?? null;

        // If a handler is found, call it
        if ($handler) {
            // Call the handler function, passing the Router instance
            call_user_func($handler, $this);
        // If no handler is found but a not found handler is set, call it
        } elseif ($this->notFoundHandler) {
            // Call the not found handler function, passing the Router instance
            call_user_func($this->notFoundHandler, $this);
        // If no handler is found and no not found handler is set, return a 404 response
        } else {
            // Send a 404 Not Found header
            header("HTTP/1.0 404 Not Found");
            // Include the not found page
            require __DIR__ . '/../views/notfound.php';
        }
    }
}
?>