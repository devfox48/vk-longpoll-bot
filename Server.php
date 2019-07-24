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

require 'API.php';
require 'network/Utils.php';
require 'network/LongPoll.php';
require 'utils/Functions.php';

$lp = new LongPoll();

while (true) {
    foreach ($lp->updates() as $update) {
        if ($update['type'] == "message_new" and $update['object']['from_id'] > 0) {
            if ($update['object']['out'] == 0) {
                $peer_id = $update['object']['peer_id'];
                $user_id = $update['object']['from_id'];
                $message = $update['object']['text'];
                $message = mb_strtolower($message, 'UTF-8');

                if (preg_match("/^(test)$/", $message)) {
                    message_send("Test complete.", $peer_id);
                } else message_send("This command does exists.", $peer_id);
            }
        }
    }
}
