<?php

/*
*
 ____             _____         _  _    ___  
|  _ \  _____   _|  ___|____  _| || |  ( _ ) 
| | | |/ _ \ \ / / |_ / _ \ \/ / || |_ / _ \ 
| |_| |  __/\ V /|  _| (_) >  <|__   _| (_) |
|____/ \___| \_/ |_|  \___/_/\_\  |_|  \___/ 

    Author: DevFox48
    Github: https://github.com/devfox48
    VK: https://vk.com/sergey_dev
*    
*/
 
class Utils {

  public static function curl_get($url, $params) {

    $url = $url . "?" . http_build_query($params);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
  }

  public static function vk_request($method, $params) {
    $params["access_token"] = Config::TOKEN;
    $params["v"] = Config::API;

    $res = self::curl_get("https://api.vk.com/method/$method", $params);

    if (!isset($res["response"])) {
      print($res["error"]["error_msg"] . PHP_EOL);
      return false;
    }

    return $res["response"];
  }
}
