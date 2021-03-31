<?php
  class bot{
      public $token = '';
      public $d_textm, $d_fname, $d_username, $d_type, $d_chatid, $d_messageid, $d_cbdata, $d_cbid;

      public function __construct ($token){
        $this -> token = $token; 
      }

        function update($data){
          $this -> d_text = $data['message']['text'];
          $this -> d_fname = $data['message']['chat']['first_name'];
          $this -> d_username = $data['message']['chat']['username'];
          $this -> d_type = $data['message']['chat']['type'];
          $this -> d_chatid = $data['message']['chat']['id'];
          $this -> d_messageid = $data['message']['message_id'];
          $this -> d_cbdata = $data['callback_query']['data'];
          $this -> d_cbid = $data['callback_query']['message']['chat']['id'];
      }

      public function send($chatid, $message){
        
        $url = "https://api.telegram.org/bot".$this -> token."/sendMessage";
        $param = array(
          'chat_id' => $chatid,
          'text' => $message
        );
        // use key 'http' even if you send the request to https://...
        $options = array(
          'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($param)
          )
        );  
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
      }

      public function send_html($chatid, $message){
        
        $url = "https://api.telegram.org/bot".$this -> token."/sendMessage";
        $param = array(
          'chat_id' => $chatid,
          'text' => $message,
          'parse_mode' => 'HTML',
          'disable_web_page_preview' => true
        );
        // use key 'http' even if you send the request to https://...
        $options = array(
          'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($param)
          )
        );  
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
      }

      public function send_keyb($chatid, $message, $keyb){
        
        $url = "https://api.telegram.org/bot".$this -> token."/sendMessage";
        $param = array(
          'chat_id' => $chatid,
          'text' => $message,
          'reply_markup' =>$keyb
        );
        // use key 'http' even if you send the request to https://...
        $options = array(
          'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($param)
          )
        );  
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
      }
      
    }
  ?>