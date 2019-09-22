<?php
define('METHOD', 'DELETE');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: ' . METHOD);
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 3600');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] != METHOD) {
    
    echo json_encode(['error' => 'Expected request method "' . METHOD . '".']);
    http_response_code(405);
    die;
    
}

$contents = file_get_contents('php://input');
$data = json_decode($contents);

if (!isset($data->id)) {
    
    echo json_encode(['error' => 'Missing parameter: id']);
    http_response_code(400);
    die;
    
}

require_once('../config/config.php');
require_once('../config/Db.php');
require_once('../model/User.php');

$Db = new \Config\Db();
$conn = $Db->getConnection($host, $user, $password, $db_name);

$UserModel = new \UserApp\User($conn);

$UserModel->id = $data->id;

$User = $UserModel->getSingle();

if ($User === false) {
    
    echo json_encode(['error' => 'User not found.']);
    http_response_code(404);
    die;
    
} elseif ($UserModel->delete()) {
    
    http_response_code(204);
    die;
    
} else {
    
    if (is_string($result)) {
        
        echo json_encode(['error' => $result]);
        http_response_code(400);
        die;
        
    } else {
        
        echo json_encode(['error' => 'Could not delete user']);
        http_response_code(500);
        die;
        
    }
    
}