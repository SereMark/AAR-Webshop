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
        $this->handlers[$method.$path] = $handler;
    }

    public function setNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }

    public function dispatch($method, $path) {
        $handlerKey = $method.$path;

        if (isset($this->handlers[$handlerKey])) {
            call_user_func($this->handlers[$handlerKey]);
        } elseif ($this->notFoundHandler) {
            call_user_func($this->notFoundHandler);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }
}