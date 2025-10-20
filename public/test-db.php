<?php

require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/conn.php';
$conn = connectDB();
echo "Connected successfully to blog_db.";

?>

<br><br>

<?php

echo "Admin password: administrador <br>";
echo "Admin hashed password: <br>";
echo password_hash('administrador', PASSWORD_DEFAULT);

?>

<br><br>

<?php

echo "Users password: 12345678 <br>";
echo "Users hashed password: <br>";
echo password_hash('12345678', PASSWORD_DEFAULT);

?>
