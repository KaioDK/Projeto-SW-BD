<?php
require_once __DIR__ . '/../../backend/auth.php';
header('Content-Type: application/json; charset=utf-8');

// Unset both user and vendedor sessions
unset($_SESSION['user']);
unset($_SESSION['vendedor']);
session_destroy();

echo json_encode(['success' => true]);
