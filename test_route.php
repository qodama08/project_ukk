<?php
require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

echo "Guru BK Route: " . route('guru_bk.index') . "\n";
echo "Users Route: " . route('users.index') . "\n";
