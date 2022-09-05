<?php

$appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$connStr = "host=192.168.0.108 port=5432 dbname=postgres user=postgres password=teste options='--application_name=$appName'";

//simple check
$conn = pg_connect($connStr);
$result = pg_query($conn, "select 123");
var_dump(pg_fetch_all($result));

?>