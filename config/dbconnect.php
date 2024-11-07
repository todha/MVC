<?php
function connect()
{
    $user = "root";
    $pass = "";
    $db = "TaskManagementDb";
    $mysqli = new mysqli("localhost", $user, $pass, $db );
    if ($mysqli->connect_errno )
    {
        die( "Couldn't connect to MySQL" );
    }
    return $mysqli;
}
