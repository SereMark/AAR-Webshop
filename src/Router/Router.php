<?php

// Define the Router class
class Router {
    // Define a private property to hold the handlers
    private $handlers = [];
    // Define a private property to hold the not found handler
    private $notFoundHandler;

    // Define a method to add a GET handler
    public function get($path, $handler) {
        // Call the addHandler method with the GET method, the given path, and the given handler
        $this->addHandler('GET', $path, $handler);
    }

    // Define a method to add a POST handler
    public function post($path, $handler) {
        // Call the addHandler method with the POST method, the given path, and the given handler
        $this->addHandler('POST', $path, $handler);
    }

    // Define a private method to add a handler
    private function addHandler($method, $path, $handler) {
        // Add the handler to the handlers array with the given method and path as the keys
        $this->handlers[$method][$path] = $handler;
    }

    // Define a method to set the not found handler
    public function setNotFoundHandler($handler) {
        // Set the notFoundHandler property to the given handler
        $this->notFoundHandler = $handler;
    }

    // Define a method to dispatch the request
    public function dispatch() {
        // Get the request method from the $_SERVER superglobal
        $method = $_SERVER['REQUEST_METHOD'];
        // Get the request URI from the $_SERVER superglobal and parse it to get the path
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Get the handler for the request method and path, or null if it doesn't exist
        $handler = $this->handlers[$method][$path] ?? null;

        // If the handler exists, call it with the router as the argument
        if ($handler) {
            call_user_func($handler, $this);
        // If the handler doesn't exist but the not found handler does, call the not found handler with the router as the argument
        } elseif ($this->notFoundHandler) {
            call_user_func($this->notFoundHandler, $this);
        // If neither the handler nor the not found handler exist, send a 404 Not Found response and require the not found view
        } else {
            header("HTTP/1.0 error Not Found");
            require __DIR__ . '/../views/notfound.php';
        }
    }
}