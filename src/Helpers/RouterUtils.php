<?php
// Initialize a new controller instance
function controller($name) {
    $class = "{$name}Controller";
    return new $class();
}