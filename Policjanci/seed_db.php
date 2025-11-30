<?php
$varDir = __DIR__ . '/var';
$dbPath = $varDir . '/data.db';
$seedPath = __DIR__ . '/sql/seed.sql';

if (!file_exists($seedPath)) {
    die("[BLAD] Nie znaleziono pliku: $seedPath\n");
}

try {
    echo "[INFO] Łączenie z bazą danych SQLite...\n";
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "[INFO] Wczytywanie danych wstępnych...\n";
    $sql = file_get_contents($seedPath);

    echo "[INFO] Wstawianie danych wstępnych do bazy...\n";
    $pdo->exec($sql);

    echo "----------------------------------------------------------\n";
    echo "[SUKCES] Baza danych jest w stanie początkowym!\n";
    echo "----------------------------------------------------------\n";

} catch (PDOException $e) {
    echo "\n[BLAD KRYTYCZNY] Wystąpił błąd bazy danych:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
