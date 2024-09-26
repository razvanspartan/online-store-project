<?php
if (extension_loaded('mysqli')) {
    echo "MySQLi is enabled.\n";
} else {
    echo "MySQLi is not enabled.\n";
}

if (extension_loaded('pdo_mysql')) {
    echo "PDO MySQL is enabled.\n";
} else {
    echo "PDO MySQL is not enabled.\n";
}
?>
