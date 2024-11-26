<?php
require_once "../controllers/UserController.php";

$id = $_GET['id'];
$estado = $_GET['estado'];

$success = UserController::updateStatus($id, $estado);
echo json_encode(['success' => $success]);
