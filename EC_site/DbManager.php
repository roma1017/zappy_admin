<?php

function getDb() {
    $dsn = 'mysql:host=127.0.0.1; dbname=ec_site; charset=utf8';
    $user = 'root';
    $pass = '';

    $db = new PDO($dsn, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
    return $db;
}