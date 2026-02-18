<?php
/**
 * Gestion des sessions
 */

class SessionManager {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        session_destroy();
        $_SESSION = [];
    }
    
    public static function regenerate() {
        session_regenerate_id(true);
    }
    
    public static function isLoggedIn() {
        return self::has('user');
    }
    
    public static function getUser() {
        return self::get('user');
    }
    
    public static function setUser($user) {
        self::set('user', $user);
    }
    
    public static function hasRole($role) {
        $user = self::getUser();
        return $user && $user['role'] === $role;
    }
    
    public static function hasAnyRole($roles) {
        $user = self::getUser();
        if (!$user) return false;
        
        return in_array($user['role'], $roles);
    }
    
    public static function flash($key, $value = null) {
        if ($value === null) {
            $flash = self::get('_flash_' . $key);
            self::remove('_flash_' . $key);
            return $flash;
        } else {
            self::set('_flash_' . $key, $value);
        }
    }
    
    public static function hasFlash($key) {
        return self::has('_flash_' . $key);
    }
}

// Démarrer la session
SessionManager::start();
