<?php

namespace App\Core;

use mysqli;

class Auth
{
    /**
     * Intenta autenticar. Devuelve datos del login si tiene éxito, null si falla.
     */
    public static function attempt(mysqli $conexion, int $numControl, string $password): ?array
    {
        $stmt = $conexion->prepare(
            'SELECT id_admin, usuario, password, perfil, n_permiso FROM admins WHERE N_control = ?'
        );
        $stmt->bind_param('i', $numControl);
        $stmt->execute();
        $stmt->bind_result($idUser, $nameUser, $hashPass, $perfilUser, $permiso);

        if (!$stmt->fetch()) {
            $stmt->close();
            return null;
        }
        $stmt->close();

        if (!empty($hashPass) && !password_verify($password, $hashPass)) {
            return null;
        }

        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $nameUser;
        $_SESSION['id'] = $idUser;
        $_SESSION['numc'] = $numControl;
        $_SESSION['perfil'] = $perfilUser;
        $_SESSION['permiso'] = (int) $permiso;

        return [
            'esContrasenaPorDefecto' => hash_equals('x' . $numControl, $password),
        ];
    }

    public static function check(): bool
    {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    public static function requireLogin(string $redirectTo = 'login.html'): void
    {
        if (!self::check()) {
            header('Location: ' . $redirectTo);
            exit;
        }
    }

    public static function requirePermiso(int $nivel, string $redirectTo = 'index.php'): void
    {
        self::requireLogin();
        if ((int) ($_SESSION['permiso'] ?? 0) !== $nivel) {
            header('Location: ' . $redirectTo);
            exit;
        }
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
