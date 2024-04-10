<?php
header('Content-Type: application/json');
echo json_encode(['connected' => isDatabaseConnected()]);
exit;