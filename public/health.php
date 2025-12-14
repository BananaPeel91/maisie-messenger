<?php
// Simple health check that doesn't require Laravel
header('Content-Type: application/json');
echo json_encode(['status' => 'ok', 'timestamp' => date('c')]);

