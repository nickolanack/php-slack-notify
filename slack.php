<?php


/**
 *  Configuration: 
 *  go install Incoming Webhooks into your slack team and set it up for a channel.
 *  get the webhook service url and put that into a file named slack.token in the same directory as this file.
 */


/**
 *  Command Line Usage: 
 *  php slack.php 'Hello World'
 */


/**
 *  Class Slack
 *  
 *  include slack.php, then you can use it to send notifications to a channel however you like within some other script etc.
 *  
 *  General Usage:
 *  Slack::postMessage('Hello World');
 *  Slack::postMessage(array('text'=>'Hello World'));
 *  Slack::postMessage(array('attachments'=>array("text"=>'Hello World')));
 */


class Slack
{

    /**
     *  
     */
    public static function postMessage($message)
    {


    	$params=array();
    	if(is_string($message)){
    		$params['text']=$message;
    	}

    	if(is_array($message)||is_object($message)){
    		$params=$message;
    	}

        if(!file_exists(__DIR__.'/slack.token')){
            throw new Exception('Please put incoming webhook url in: slack.token');
        }

        $url = trim(file_get_contents(__DIR__.'/slack.token'));
        $fields = array(
            'payload' => urlencode(json_encode($params)),

        );

        $fields_string = '';

        foreach ($fields as $key => $value) {$fields_string .= $key . '=' . $value . '&';}
        rtrim($fields_string, '&');


        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);


        $result = curl_exec($ch);


        curl_close($ch);

    }

    public static function hasUrl(){
        return file_exists(__DIR__.'/slack.token');
    }

}

if (isset($argv)) {
    if (realpath($argv[0]) === __FILE__) {

        if (count($argv) > 1) {
            Slack::postMessage($argv[1]);
        } else {
            Slack::postMessage('Hello World');
        }

    }
}

