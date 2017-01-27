<?php
/**
 * Created by PhpStorm.
 * User: fokk
 * Date: 26.01.17
 * Time: 10:58
 */

    function curl_helper($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

    function getPosts($page_ID, $accessToken)
    {
        $posts = curl_helper('https://graph.facebook.com/'.$page_ID.'/posts?access_token='.(string) $accessToken);
        $array = $posts->data;
        for($i = 0; $i < count($array); $i++)
        {
            $latest_post =  $posts->data[$i];
            $text =  $latest_post->message;
            echo $text ,'<br>';
            echo "================================",'<br>';
        }

        echo '<a href="form_added_post.html">Added Post!</a>';
    }
?>