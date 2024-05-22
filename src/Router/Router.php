<?php
/**
 * Class Router
 * 
 * The Router class handles routing and dispatching of HTTP requests.
 */
class Router {
    private array $handlers = [];

    /**
     * Registers a GET route handler.
     *
     * @param string $path The route path
     * @param callable $handler The route handler function
     * @return self
     */
    public function get(string $path, callable $handler): self {
        return $this->addHandler('GET', $path, $handler);
    }

    /**
     * Registers a POST route handler.
     *
     * @param string $path The route path
     * @param callable $handler The route handler function
     * @return self
     */
    public function post(string $path, callable $handler): self {
        return $this->addHandler('POST', $path, $handler);
    }

    /**
     * Registers a PUT route handler.
     *
     * @param string $path The route path
     * @param callable $handler The route handler function
     * @return self
     */
    public function put(string $path, callable $handler): self {
        return $this->addHandler('PUT', $path, $handler);
    }

    /**
     * Registers a DELETE route handler.
     *
     * @param string $path The route path
     * @param callable $handler The route handler function
     * @return self
     */
    public function delete(string $path, callable $handler): self {
        return $this->addHandler('DELETE', $path, $handler);
    }

    /**
     * Registers a PATCH route handler.
     *
     * @param string $path The route path
     * @param callable $handler The route handler function
     * @return self
     */
    public function patch(string $path, callable $handler): self {
        return $this->addHandler('PATCH', $path, $handler);
    }

    /**
     * Adds a route handler for the specified method and path.
     *
     * @param string $method The HTTP method
     * @param string $path The route path
     * @param callable $handler The route handler function
     * @return self
     */
    private function addHandler(string $method, string $path, callable $handler): self {
        $pattern = preg_replace('/\{([\w]+)\}/', '(?<$1>[\w-]+)', $path);
        $this->handlers[$method][$pattern] = $handler;
        return $this;
    }

    /**
     * Dispatches the HTTP request to the appropriate route handler.
     *
     * @return void
     */
    public function dispatch(): void {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            $requestedUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            $routeFound = false;
            foreach ($this->handlers[$method] ?? [] as $pattern => $handler) {
                if (preg_match("#^$pattern$#", $requestedUrl, $matches)) {
                    array_shift($matches);
                    call_user_func_array($handler, [$this, $matches]);
                    $routeFound = true;
                    break;
                }
            }

            if (!$routeFound) {
                $this->respondNotFound();
            }
        } catch (\Exception $e) {
            $this->respondInternalError($e);
        }
    }

    /**
     * Sends a 404 Not Found response.
     *
     * @return void
     */
    private function respondNotFound(): void {
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../views/notfound.php';
    }

    /**
     * Sends a 500 Internal Server Error response.
     *
     * @param \Exception $e The exception object
     * @return void
     */
    private function respondInternalError(\Exception $e): void {
        header("HTTP/1.1 500 Internal Server Error");
        echo "500 Internal Server Error: " . $e->getMessage();
    }
}
?>