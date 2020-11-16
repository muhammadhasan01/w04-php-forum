<?php

$SERVER = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DB_NAME = 'forumdb';

$db = new mysqli($SERVER, $USERNAME, $PASSWORD, $DB_NAME) or die(mysqli_error($db));

?>