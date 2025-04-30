<?php
require_once("../Models/loginModel.php");
require_once("../models/Database.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json);


$name = $data->name;
$username = $data->username;
$email = $data->email;
$password = $data->password;

$user = new LoginModel($name, $username, $email, $password);
$userData = $user->save($name, $username, $email, $password);
