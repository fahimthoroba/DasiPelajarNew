<?php
$hosts = ['127.0.0.1', '172.17.0.1', 'localhost', 'mariadb'];
$passwords = [
    '',
    'root',
    'password',
    'admin',
    '123456',
    'casaos',
    'mariadb',
    'laravel',
    'secret',
    'dasi_db'
];
$user = 'root';
$port = 3306;

foreach ($hosts as $host) {
    echo "Testing host: $host\n";
    foreach ($passwords as $password) {
        try {
            $pdo = new PDO("mysql:host=$host;port=$port", $user, $password);
            echo "SUCCESS: Connected to $host with password: '$password'\n";
            exit(0);
        } catch (PDOException $e) {
            // echo "Failed: " . $e->getMessage() . "\n";
            continue;
        }
    }
}
echo "FAILURE: Could not connect with any common password.\n";
