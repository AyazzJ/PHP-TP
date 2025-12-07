<?php
namespace App\Models;

use App\Core\Database;

class User
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function register($email, $name, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $activationToken = bin2hex(random_bytes(32));

        $this->db->query(
            "INSERT INTO users (email, name, password_hash, activation_token, is_active) VALUES (?, ?, ?, ?, 0)",
            [$email, $name, $hashedPassword, $activationToken]
        );

        return $activationToken;
    }

    public function getUserByEmail($email)
    {
        return $this->db->fetch(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
    }

    public function getUserByName($name)
    {
        return $this->db->fetch(
            "SELECT * FROM users WHERE name = ?",
            [$name]
        );
    }

    public function confirmEmail($token)
    {
        return $this->db->query(
            "UPDATE users SET is_active = 1 WHERE activation_token = ?",
            [$token]
        )->rowCount() > 0;
    }

    public function requestPasswordReset($email)
    {
        $resetToken = bin2hex(random_bytes(32));
        $this->db->query(
            "UPDATE users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?",
            [$resetToken, $email]
        );
        return $resetToken;
    }

    public function resetPassword($token, $newPassword)
    {
        $user = $this->db->fetch(
            "SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()",
            [$token]
        );

        if (!$user) {
            return false;
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        return $this->db->query(
            "UPDATE users SET password_hash = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?",
            [$hashedPassword, $user['id']]
        )->rowCount() > 0;
    }

    public function authenticate($name, $password)
    {
        $user = $this->getUserByName($name);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return null;
        }

        if (!$user['is_active']) {
            return null; // User hasn't confirmed email
        }

        return $user;
    }
}
