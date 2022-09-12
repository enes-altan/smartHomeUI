<?php
function db_connect() {
    global $hostname, $username, $password, $database;

    if(defined('_HOSTNAME_')) $hostname=_HOSTNAME_;
    if(defined('_USERNAME_')) $username=_USERNAME_;
    if(defined('_PASSWORD_')) $password=_PASSWORD_;
    if(defined('_DATABASE_')) $database=_DATABASE_;

    if (!$hostname || !$username || !$database)	{
        $db_hata="Veritabanina Bağlanmak için yeterli parametre yok.";
        return false;
    }

    $connection = new mysqli($hostname,$username,$password,$database);
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    return $connection;
}