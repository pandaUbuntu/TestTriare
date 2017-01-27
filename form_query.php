<?php
/**
 * Created by PhpStorm.
 * User: fokk
 * Date: 27.01.17
 * Time: 10:25
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once 'Facebook/autoload.php';
require_once 'config.php';

use Facebook\Facebook;
use Facebook\FacebookRequest;

$fb = new Facebook($config);

$helper = $fb->getRedirectLoginHelper();


try
{
    $accessToken = $helper->getAccessToken();
}
catch(Facebook\Exceptions\FacebookResponseException $e)
{
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
}
catch(Facebook\Exceptions\FacebookSDKException $e)
{
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$params = array(
    'message' => $_POST['message'],
    'picture' => $_POST['picture'],
    'link' => $_POST['link'],
    'name' => $_POST['name'],
    'caption' => $_POST['caption'],
    'description' => $_POST['description']
);

$parameters['access_token'] = $_SESSION['active']['access_token'];

$newpost = $fb->api(
    '/me/feed',
    'POST',
    $params
);

?>