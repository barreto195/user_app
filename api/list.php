<?php
define('METHOD', 'GET');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: ' . METHOD);
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] != METHOD) {
    
    echo json_encode(['error' => 'Expected request method "' . METHOD . '".']);
    http_response_code(405);
    die;
    
}

require_once('../config/config.php');
require_once('../config/Db.php');
require_once('../model/User.php');

$Db = new \Config\Db();
$conn = $Db->getConnection($host, $user, $password, $db_name);

$UserModel = new \UserApp\User($conn);

$users = $UserModel->getAll();

if (count($users) > 0) {
    
    echo json_encode($users);
    http_response_code(200);
    die;
    
} else {
    
    echo json_encode(['error' => 'No users found.']);
    http_response_code(404);
    die;
    
}