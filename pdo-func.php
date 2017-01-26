<?php
/**
 * Created by PhpStorm.
 * User: fokk
 * Date: 26.01.17
 * Time: 13:23
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'connection.php';


function insertUserName($response)
{
    $user = $response->getGraphUser();
    $name = $user['name'];
    $host = "localhost";
    $db_name = "developer_f10";
    $user_db = "developer_f10";
    $password = "cFDOswyq";

    $conn = new mysqli($host, $user_db, $password, $db_name);

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO user_data (name_user) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) /*{
        echo "New record created successfully";
    } else {
        echo "Err: " . $sql . "<br>" . $conn->error;
    }*/

    $conn->close();
}

?>