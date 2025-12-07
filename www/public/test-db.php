<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Core\Database;
use App\Models\User;

$db = new Database();
$userModel = new User($db);

// Check all users
$users = $db->fetchAll("SELECT id, email, name FROM users");
echo "<pre>";
echo "All users in database:\n";
print_r($users);
echo "\n";

// Check specific email
$email = 'ayaz.jubaer@gmail.com';
$user = $userModel->getUserByEmail($email);
echo "Search result for '$email':\n";
var_dump($user);
echo "</pre>";
?>