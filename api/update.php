<?php
define('METHOD', 'PUT');

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

if (
    !isset($data->id)
    or !isset($data->name)
    or !isset($data->email)
    or !isset($data->birthdate)
    or !isset($data->gender)
) {
    
    echo json_encode(['error' => 'One or more required parameters are missing.']);
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
$UserModel->name = $data->name;
$UserModel->email = $data->email;
$UserModel->birthdate = $data->birthdate;
$UserModel->gender = $data->gender;

$User = $UserModel->getSingle();

if ($User === false) {
    
    echo json_encode(['error' => 'User not found.']);
    http_response_code(404);
    die;
    
} else {
    
    $result = $UserModel->update();
    
    if ($result === true) {
        
        $User = $UserModel->getSingle();
        
        echo json_encode($User);
        http_response_code(200);
        die;
        
    } else {
        
        if (is_string($result)) {
            
            echo json_encode(['error' => $result]);
            http_response_code(400);
            die;
            
        } else {
            
            echo json_encode(['error' => 'Could not update user']);
            http_response_code(500);
            die;
            
        }
        
    }
    
}