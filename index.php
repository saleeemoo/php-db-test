<?php
// ─── يقرأ بيانات الاتصال من environment variables ───
// هذي القيم نحطها في Coolify، مو في الكود — أمان + مرونة
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$name = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

header('Content-Type: text/html; charset=utf-8');
echo "<h1>PHP + MariaDB Connection Test</h1>";
echo "<p>PHP version: " . phpversion() . "</p>";

try {
    // ─── محاولة الاتصال بقاعدة البيانات ───
    $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ]);

    echo "<p style='color:green;font-weight:bold'>";
    echo "✅ Connected to database '$name' successfully";
    echo "</p>";

    // ─── اختبار استعلام بسيط ───
    $stmt = $pdo->query("SELECT VERSION() AS version, NOW() AS server_time");
    $row  = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<p>MariaDB version: " . htmlspecialchars($row['version']) . "</p>";
    echo "<p>Server time: "    . htmlspecialchars($row['server_time']) . "</p>";

} catch (PDOException $e) {
    // ─── لو فشل الاتصال، يعرض السبب ───
    echo "<p style='color:red;font-weight:bold'>";
    echo "❌ Connection failed: " . htmlspecialchars($e->getMessage());
    echo "</p>";
}
