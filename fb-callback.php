<?php
/**
 * Created by PhpStorm.
 * User: fokk
 * Date: 24.01.17
 * Time: 11:05
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$page_ID = '1852511061698792';

require_once 'Facebook/autoload.php';
require_once 'config.php';
require_once 'get-posts.php';
require_once 'pdo-func.php';

use Facebook\Facebook;
use Facebook\FacebookRequest;
use Facebook\FacebookClient;

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

    $response = $fb->get('/me?fields=id,name', $accessToken);

    $user = $response->getGraphUser();
    $name = $user['name'];
    $user_id = $response->getGraphUser()->getId();
    echo "-------------------------" . '<br>';
    $url="http://www.facebook.com/". $user_id;
    $id =  substr(strrchr($url,'/'),1);



    echo "<img src=\"http://graph.facebook.com/" . $id . "/picture?type=large\"/>";
    echo "<br>";
    echo "-------------------------" . '<br>';
    echo $name;
    echo "<br>";
    echo "-------------------------" . '<br>';


    insertUserName($response);

    if (! isset($accessToken))
    {
        if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper->getError() . "\n";
            echo "Error Code: " . $helper->getErrorCode() . "\n";
            echo "Error Reason: " . $helper->getErrorReason() . "\n";
            echo "Error Description: " . $helper->getErrorDescription() . "\n";
        }
        else
        {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        exit;
    }



// Logged in
   /* echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    echo '<h3>Metadata</h3>';
    var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId($app_id);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();*/

    if (! $accessToken->isLongLived())
    {
    // Exchanges a short-lived access token for a long-lived one
        try
        {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        }
        catch (Facebook\Exceptions\FacebookSDKException $e)
        {
            echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
            exit;
        }

        echo '<h3>Long-lived</h3>';
        var_dump($accessToken->getValue());
    }

    $_SESSION['fb_access_token'] = (string) $accessToken;
    


    getPosts($page_ID, $accessToken);
?>