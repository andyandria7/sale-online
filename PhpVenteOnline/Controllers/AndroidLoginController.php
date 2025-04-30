<?php
require_once("../Models/loginModel.php");
require_once("../models/Database.php");


// var_dump(file_exists("../Models/loginModel.php"));
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }

$json = file_get_contents('php://input');
$data = json_decode($json);


$email = $data->email;
$password = $data->password;

if (!$data) {
    $data = (object) $_POST;
}

// if (!isset($data->email) || !isset($data->password)) {
//     echo json_encode(["success" => false, "error" => "Email and password required"]);
//     exit();
// }

$email = $data->email;
$password = $data->password;

$user = new LoginModel("", "", $email, $password);
$userData = $user->login($email, $password);



if ($userData) {
    echo json_encode(["success" => true, "user" => $userData]);
} else {
    echo json_encode(["success" => false, "error" => "Invalid credentials"]);
}