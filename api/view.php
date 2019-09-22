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

if (!isset($_GET['id'])) {
    
    echo json_encode(['error' => 'Missing parameter: id']);
    http_response_code(400);
    die;
    
}

require_once('../config/config.php');
require_once('../config/Db.php');
require_once('../model/User.php');

$id = $_GET['id'];

$Db = new \Config\Db();
$conn = $Db->getConnection($host, $user, $password, $db_name);

$UserModel = new \UserApp\User($conn);

$UserModel->id = $id;

$User = $UserModel->getSingle();

if ($User !== false) {
    
    echo json_encode($User);
    http_response_code(200);
    die;
    
} else {
    
    echo json_encode(['error' => 'User not found.']);
    http_response_code(404);
    die;
    
}