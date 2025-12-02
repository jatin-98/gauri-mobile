<?php

namespace App\Core;

class Session
{
    /**
     * The main session array key to store all app data
     */
    private static string $sessionKey = '_GAURI_MOBILES';

    /**
     * Ensure session is started and app storage exists
     */
    private static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[self::$sessionKey])) {
            $_SESSION[self::$sessionKey] = [];
        }

        if (!isset($_SESSION[self::$sessionKey]['_flash'])) {
            $_SESSION[self::$sessionKey]['_flash'] = [];
        }
    }

    /**
     * Store a value in session
     */
    public static function put(string $key, $value): void
    {
        self::init();
        $_SESSION[self::$sessionKey][$key] = $value;
    }

    /**
     * Get a value from session
     */
    public static function get(string $key, $default = null)
    {
        self::init();
        return $_SESSION[self::$sessionKey][$key] ?? $default;
    }

    /**
     * Flash data (available for one request only)
     */
    public static function flash(string $key, $value): void
    {
        self::init();
        $_SESSION[self::$sessionKey]['_flash'][$key] = $value;
    }

    /**
     * Retrieve and clear flash data
     */
    public static function getFlash(string $key)
    {
        self::init();
        $value = $_SESSION[self::$sessionKey]['_flash'][$key] ?? null;
        unset($_SESSION[self::$sessionKey]['_flash'][$key]);
        return $value;
    }

    /**
     * Forget a specific key
     */
    public static function forget(string $key): void
    {
        self::init();
        unset($_SESSION[self::$sessionKey][$key]);
    }

    /**
     * Completely destroy app session data
     */
    public static function destroy(): void
    {
        self::init();
        unset($_SESSION[self::$sessionKey]);
    }
}
