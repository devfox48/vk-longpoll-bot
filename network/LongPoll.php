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

  class LongPoll {
    private $server, $key;
    private $ts;

    public function __construct() {
      $this->getLongPolling();
    }

    public function getLongPolling() {
      $data = Utils::vk_request("groups.getLongPollServer", ["group_id"=>Config::GROUP_ID]);
      if($data == false)
        exit("Failed to get longpolling data...\n");
      $this->server = $data["server"];
      $this->key = $data["key"];
      $this->ts = $data["ts"];
    }

    public function updates() {
      $params = [
          "act"=>"a_check", "key"=>$this->key,
          "ts"=>$this->ts, "mode"=>2, 
          "version"=>2, "wait"=>30
      ];
      $updates = Utils::curl_get($this->server, $params);
       if(isset($updates["failed"])){
         $this->getLongPolling();
         return $this->updates();
       }
       $this->ts = $updates["ts"];
       return $updates["updates"];
    }
  }
