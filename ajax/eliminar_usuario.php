<?php
require_once "../controllers/UserController.php";

$id = $_GET['id'];

$success = UserController::deleteUser($id);
echo json_encode(['success' => $success]);
