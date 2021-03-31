 <?php
  include __DIR__ . '/classes/class_bot.php';
  include __DIR__ . '/classes/class_cryptosoul.php';

  function mysqlib(){
    $mysqli = @new mysqli('localhost', 'username', 'password', 'table');
    return $mysqli;
  }

  function inline_keyboard($keyb){
    //$keyb -  '[ [{"text": "text", "callback_data":"callback"}], [{"text": "text", "callback_data":"callback"}] ]
    $a = '{"inline_keyboard":' . $keyb . '}';
    return $a;
  }

  function keyboard($keyb, $res, $onetk, $selc)
  { 
    //$keyb - клавиатура [["opt 1","opt 2","opt 3"],["menu"]]
    //$res -  resize_keyboard (true/false)
    //$onetk - one_time_keyboard (true/false)
    //$selc - selective (true/false) 
    $a = '{"keyboard":' . $keyb . ', "resize_keyboard":' . $res . ', "one_time_keyboard":' . $onetk . ', "selective":' . $selc . '}';
    return $a;
  }

 ?>