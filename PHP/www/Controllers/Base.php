<?php
// Controllers/Base.php

class Base
{
    public function index(): void
    {
        echo "<h1>Base index</h1>";
    }

    public function contact(): void
    {
        echo "<h1>Base contact</h1>";
    }

    public function error404(): void
    {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1><p>The requested route does not exist.</p>";
    }
}