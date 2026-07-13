<?php

if (!function_exists('asset')) {
    /**
     * Generate a full URL for an asset in the public directory.
     *
     * @param  string  $path
     * @return string
     */
    function asset(string $path): string
    {
        // Detect the current scheme (http or https)
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

        $scheme = $isSecure ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // Determine base path (remove 'public' from document root)
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = rtrim($basePath, '/');

        // Build and return full asset URL
        return sprintf('%s://%s%s/%s', $scheme, $host, $basePath, ltrim($path, '/'));
    }
}


if (!function_exists('app')) {
    function app($abstract = null)
    {
        $container = \Illuminate\Container\Container::getInstance();
        return $abstract ? $container->make($abstract) : $container;
    }
}

if (!function_exists('view')) {
    function view($template, $data = [])
    {
        return app('view')->make($template, $data);
    }
}

if (!function_exists('app_base_url')) {
    function app_base_url(): string
    {
        // Detect protocol
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ($_SERVER['SERVER_PORT'] ?? null) == 443;

        $scheme = $isSecure ? 'https' : 'http';

        // Example: localhost:8080
        $host = $_SERVER['HTTP_HOST'];

        // Detect project directory correctly (public folder safe)
        $scriptDir = str_replace('/public', '', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

        return rtrim("$scheme://$host$scriptDir", '/');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

        $scheme = $isSecure ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $basePath = rtrim($basePath, '/');

        return sprintf('%s://%s%s/%s', $scheme, $host, $basePath, ltrim($path, '/'));
    }
}


if (!function_exists('route')) {
    /**
     * Generate a URL for a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @return string
     */
    function route(string $name, array $parameters = []): string
    {
        // Get router from container
        $router = app('router');

        // Get the route collection
        $routes = $router->getRoutes();

        // Find route by name
        $route = $routes->getByName($name);

        if (!$route) {
            throw new Exception("Route [{$name}] not found.");
        }

        // Build URL using route's URI pattern
        $uri = $route->uri();

        // Replace route parameters (like {id})
        foreach ($parameters as $key => $value) {
            $uri = str_replace("{{$key}}", urlencode($value), $uri);
        }

        // Build full URL
        return rtrim(url('/'), '/') . '/' . ltrim($uri, '/');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path = '')
    {
        // If absolute URL already, don't modify
        if (preg_match('#^https?://#', $path)) {
            $redirectUrl = $path;
        } else {
            $redirectUrl = url($path);
        }

        header("Location: $redirectUrl");
        exit;
    }
}

if (!function_exists('dump')) {
    function dump(...$vars)
    {
        echo "<pre style='
            background:#1e1e1e;
            color:#00b3ff;
            padding:15px;
            border-radius:10px;
            font-size:14px;
            line-height:1.4;
            font-family:Consolas, monospace;
        '>";

        foreach ($vars as $var) {
            var_dump($var);
        }

        echo "</pre>";
    }
}

if (!function_exists('numberToWords')) {
    function numberToWords($num)
    {
        $a = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        // Define a closure (anonymous function) to handle the conversion logic
        // We use 'use' to access the $a and $b arrays from the parent scope
        $numToWords = function ($n, $s) use ($a, $b) {
            $str = '';
            if ($n > 19) {
                $str .= $b[(int)floor($n / 10)] . ($n % 10 ? ' ' . $a[$n % 10] : '');
            } else {
                $str .= $a[$n];
            }
            return $str ? $str . $s : '';
        };

        if ($num == 0) return 'Zero Rupees';

        // Handle decimals (Paise)
        $paise = round(($num - floor($num)) * 100);
        $num = floor($num);

        $result = '';
        // Crores
        $result .= $numToWords((int)floor($num / 10000000), ' Crore ');
        // Lakhs
        $result .= $numToWords((int)floor(($num / 100000) % 100), ' Lakh ');
        // Thousands
        $result .= $numToWords((int)floor(($num / 1000) % 100), ' Thousand ');
        // Hundreds
        $result .= $numToWords((int)floor(($num / 100) % 10), ' Hundred ');
        // Last two digits
        $result .= $numToWords((int)($num % 100), '');

        $result = trim($result) . ' Rupees';

        if ($paise > 0) {
            $result .= ' and ' . $numToWords((int)$paise, '') . ' Paise';
        }

        return $result . ' Only';
    }
}

if (!function_exists('env')) {
    /**
     * Gets an environment variable by key.
     * Reads from $_ENV, $_SERVER, or getenv() — no package required.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null) {
            return $default;
        }

        // Cast common string booleans
        return match (strtolower((string) $value)) {
            'true'  => true,
            'false' => false,
            'null'  => null,
            default => $value,
        };
    }
}

if (!function_exists('formatSize')) {

    function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;

        return number_format($bytes / pow(1024, $power), 2) . ' ' . $units[$power];
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        return \App\Core\Session::token();
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}
