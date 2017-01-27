<?php
//print "TTTest"; //debug
/**
 * Created by PhpStorm.
 * User: fokk
 * Date: 24.01.17
 * Time: 10:18
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
require_once 'Facebook/autoload.php';
require_once 'config.php';


use Facebook\Facebook;

$callback = "http://dev10.fox.ck.ua/fb-callback.php";

    $fb = new Facebook($config);


    $helper = $fb->getRedirectLoginHelper();
    
    $permissions = ['publish_actions','manage_pages','publish_pages'];
    $loginUrl = $helper->getLoginUrl($callback, $permissions);
    
    echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>