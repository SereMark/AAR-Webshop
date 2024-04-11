<?php

class Router {
    private $handlers = [];
    private $notFoundHandler;

    public function get($path, $handler) {
        $this->addHandler('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addHandler('POST', $path, $handler);
    }

    private function addHandler($method, $path, $handler) {
        $this->handlers[$method][$path] = $handler;
    }

    public function setNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }

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