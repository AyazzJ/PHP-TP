<?php
namespace App\Controllers;

use App\Core\Render;
use App\Core\Database;
use App\Core\Email;
use App\Models\User;

class Auth
{
    private User $userModel;
    private Email $emailService;

    public function __construct()
    {
        $db = new Database();
        $this->userModel = new User($db);
        $this->emailService = new Email();
    }

    public function login(): void
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            error_log("Login attempt: email='$email', password='$password'");

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                header('Location: /phptest/dashboard');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect";
            }
        }

        $render = new Render("login", "backoffice");
        $render->assign("error", $error);
        $render->render();
    }

    public function register(): void
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $name = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($email) || empty($name) || empty($password)) {
                $error = "Tous les champs sont obligatoires";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères";
            } elseif ($this->userModel->getUserByEmail($email)) {
                $error = "Cet email est déjà utilisé";
            } elseif ($this->userModel->getUserByName($name)) {
                $error = "Ce nom d'utilisateur est déjà utilisé";
            } else {
                $activationToken = $this->userModel->register($email, $name, $password);
                // Send verification email
                $this->emailService->sendVerificationEmail($email, $name, $activationToken);
                $success = "Inscription réussie! Vérifiez votre email pour confirmer votre compte.";
            }
        }

        $render = new Render("register", "backoffice");
        $render->assign("error", $error);
        $render->assign("success", $success);
        $render->render();
    }

    public function passwordReset(): void
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                $error = "Veuillez entrer votre email";
            } else {
                $user = $this->userModel->getUserByEmail($email);
                if ($user) {
                    $resetToken = $this->userModel->requestPasswordReset($email);
                    // Send password reset email
                    $this->emailService->sendPasswordResetEmail($email, $user['name'], $resetToken);
                    $success = "Un email de réinitialisation a été envoyé. Vérifiez votre boîte de réception.";
                } else {
                    $success = "Si cet email existe, un lien de réinitialisation a été envoyé.";
                }
            }
        }

        $render = new Render("password_reset", "backoffice");
        $render->assign("error", $error);
        $render->assign("success", $success);
        $render->render();
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /phptest/login');
        exit;
    }

    public function dashboard(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /phptest/login');
            exit;
        }

        $render = new Render("dashboard", "backoffice");
        $render->assign("name", $_SESSION['name']);
        $render->assign("email", $_SESSION['email']);
        $render->render();
    }

    public function debugDb(): void
    {
        $db = new Database();

        echo "<pre style='background:#f0f0f0;padding:20px;'>";
        echo "=== DATABASE DEBUG ===\n\n";

        $users = $db->fetchAll("SELECT id, email, name FROM users");
        echo "All users in database:\n";
        print_r($users);
        echo "\n";

        $testEmail = 'ayaz.jubaer@gmail.com';
        $result = $db->fetch("SELECT * FROM users WHERE email = ?", [$testEmail]);
        echo "Search for '$testEmail':\n";
        var_dump($result);
        echo "\n";

        $user = $this->userModel->getUserByEmail($testEmail);
        echo "User model result for '$testEmail':\n";
        var_dump($user);
        echo "</pre>";
    }

    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? '';
        $error = null;
        $success = null;

        if (empty($token)) {
            $error = "Token de vérification manquant";
        } else {
            if ($this->userModel->confirmEmail($token)) {
                $success = "Email vérifié avec succès! Vous pouvez maintenant vous connecter.";
            } else {
                $error = "Token invalide ou expiré";
            }
        }

        $render = new Render("verify_email", "backoffice");
        $render->assign("error", $error);
        $render->assign("success", $success);
        $render->render();
    }

    public function resetPasswordForm(): void
    {
        $token = $_GET['token'] ?? '';
        $error = null;
        $success = null;

        if (empty($token)) {
            $error = "Token de réinitialisation manquant";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($password) || empty($confirmPassword)) {
                $error = "Tous les champs sont obligatoires";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères";
            } else {
                if ($this->userModel->resetPassword($token, $password)) {
                    $success = "Mot de passe réinitialisé avec succès! Vous pouvez maintenant vous connecter.";
                    error_log("Password reset successful for token: " . $token);
                } else {
                    $error = "Token invalide ou expiré";
                    error_log("Password reset FAILED for token: " . $token);
                }
            }
        }

        $render = new Render("reset_password_form", "backoffice");
        $render->assign("error", $error);
        $render->assign("success", $success);
        $render->assign("token", $token);
        $render->render();
    }

    public function checkPassword(): void
    {
        $db = new Database();
        $user = $db->fetch("SELECT id, name, email, password_hash, reset_token, reset_expires, is_active FROM users WHERE name = ?", ['ayaz']);
        echo "<pre style='background:#f0f0f0;padding:20px;font-family:monospace;'>";
        echo "=== PASSWORD DEBUG ===\n\n";
        echo "User data:\n";
        print_r($user);
        echo "\n";

        if ($user) {
            $testPassword = $_GET['pwd'] ?? 'test123';
            echo "Testing password: '$testPassword'\n";
            echo "Hash in DB: " . $user['password_hash'] . "\n";
            echo "Verify result: " . (password_verify($testPassword, $user['password_hash']) ? 'TRUE ✓' : 'FALSE ✗') . "\n";
            echo "\n";
            echo "is_active: " . ($user['is_active'] ? 'TRUE ✓' : 'FALSE ✗') . "\n";
            echo "Reset token: " . ($user['reset_token'] ? 'SET' : 'NULL') . "\n";
            echo "Reset expires: " . ($user['reset_expires'] ? $user['reset_expires'] : 'NULL') . "\n";
        }
        echo "</pre>";
    }
}