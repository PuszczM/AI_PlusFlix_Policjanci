<?php
$varDir = __DIR__ . '/var';
$dbPath = $varDir . '/data.db';
$schemaPath = __DIR__ . '/sql/schema.sql';

if (!is_dir($varDir)) {
    echo "[INFO] Tworzę folder /var...\n";
    mkdir($varDir, 0777, true);
}

if (!file_exists($schemaPath)) {
    die("[BLAD] Nie znaleziono pliku struktury: $schemaPath\n");
}

try {
    echo "[INFO] Łączenie z bazą danych SQLite...\n";
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "[INFO] Wczytywanie schematu tabel...\n";
    $sql = file_get_contents($schemaPath);

    echo "[INFO] Tworzenie tabel...\n";
    $pdo->exec($sql);

    echo "----------------------------------------------------------\n";
    echo "[SUKCES] Baza danych została utworzona poprawnie!\n";
    echo "         Plik bazy: var/data.db\n";
    echo "----------------------------------------------------------\n";

} catch (PDOException $e) {
    echo "\n[BLAD KRYTYCZNY] Wystąpił błąd bazy danych:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
