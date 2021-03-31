<?php
  class cryptosoul {
      public $key = '';
      public function __construct($rkey)  {
          $this -> key = $rkey; 
      }
      
      public function aviablelb(){
        $url = "http://51.15.85.3/api/mobile/getlootboxesinfo?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $url2 = "http://51.15.85.3/api/mobile/time";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);

        $result = file_get_contents($url2, false, $context);
        $time = json_decode($result);

        $jsonrez2 = $jsonrez -> CooldownedLootboxes;
        $olddate = substr($jsonrez2['0'] -> lastOpenTime, 0, -3);
        $newdate = substr($time -> Time, 0, -3);

        $hours = (($newdate - $olddate)/3600)%24;
        $min =  ( ( (($newdate - $olddate)/3600) - (($newdate - $olddate)/3600)%24 ) * 60 ) % 100;
        
        $return = "📦Кейсы на складе📦\n\n- Iron Capsule: ".($jsonrez -> UsualLootboxes['0'] -> amount)." шт.\n".
            "- Gold Capsule: ".($jsonrez -> UsualLootboxes['1'] -> amount)." шт.\n".
            "- Diamond Capsule: ".($jsonrez -> UsualLootboxes['2'] -> amount)." шт.\n\n".
            "🎁 Бесплатный кейс был открыт $hours часов $min минут назад";
        return $return;
      }
      public function openlootbox($id){
        $url = "http://51.15.85.3/api/mobile/openlootbox?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22,%22LootboxId%22:".$id."%7D ";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);

        if (($jsonrez -> Status) == 0){
             $case = "";
             switch ($jsonrez -> LootboxId){
                 case 1:
                     $case = "Wooden capsule";
                     break;
                 case 2:
                     $case = "Iron capsule";
                     break;
                 case 3:
                     $case = "Golden capsule";
                     break;
                 case 4:
                     $case = "Diamond capsule";
                     break;
             }
             $return = "Вы успешно открыли $case!\n\nПолучено:\n💧Бутылочек: ".
                 ($jsonrez -> ScienceReward).
                 "\n💰Соулов: ".
                 ($jsonrez -> HardReward)."\n".
                 "Карты:\n-ID: ".
                 ($jsonrez -> CardRewards['0'] -> id)."\n".
                 "-Amount: ".
                 ($jsonrez -> CardRewards['0'] -> amount)."\n".
                 "-ID: ".($jsonrez -> CardRewards['0'] -> id)."\n".
                 "-Amount: ".($jsonrez -> CardRewards['1'] -> amount)."\n\n".
                 "💲Jackpot: ".
                 ($jsonrez -> JackpotPool)."💲";
             return $return;

         } else{
             return "🚫 У вас нет доступных для открытия LootBox-ов 🚫";
         }
      }
      public function account(){
        $url = "http://51.15.85.3/api/mobile/validation?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $url2 = "http://51.15.85.3/api/mobile/applicationinitialization?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);
        $result = file_get_contents($url2, false, $context);
        $jsonrez2 = json_decode($result);



        $return =
            "🎓Ник: ".($jsonrez2 -> Nick)."\n\n".
            "📪Email: ".($jsonrez2 -> Email)."\n".
            "💵Баланс: ".($jsonrez -> Balance)."\n".
            "⭐Статус: ".($jsonrez -> Membership)."\n".
            "📈Множитель: ".($jsonrez -> Multiplier)."\n".
            "💧Бутылочек: ".($jsonrez -> Science)."\n\n".
            "Реферальная ссылка: ".($jsonrez2 -> ReferralLink)
        ;

        return $return;

      }
      public function top(){
        $url = "http://51.15.85.3/api/mobile/leaderboard?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);



        $return =
            "🏆Рейтинговая таблица(ТОП-5)🏆\n\n".
            
            "1. ".($jsonrez -> Top['0'] -> Nickname)."\n".
            "⭐ "."~".substr(($jsonrez -> Top['0'] -> Score), 0, 5)." * 10^".(iconv_strlen(($jsonrez -> Top['0'] -> Score))-5)."\n".
            "2. ".($jsonrez -> Top['1'] -> Nickname)."\n".
            "⭐ "."~".substr(($jsonrez -> Top['1'] -> Score), 0, 5)." * 10^".(iconv_strlen(($jsonrez -> Top['1'] -> Score))-5)."\n".
            "3. ".($jsonrez -> Top['2'] -> Nickname)."\n".
            "⭐ "."~".substr(($jsonrez -> Top['2'] -> Score), 0, 5)." * 10^".(iconv_strlen(($jsonrez -> Top['2'] -> Score))-5)."\n".
            "4. ".($jsonrez -> Top['2'] -> Nickname)."\n".
            "⭐ "."~".substr(($jsonrez -> Top['3'] -> Score), 0, 5)." * 10^".(iconv_strlen(($jsonrez -> Top['3'] -> Score))-5)."\n".
            "5. ".($jsonrez -> Top['4'] -> Nickname)."\n".
            "⭐ "."~".substr(($jsonrez -> Top['2'] -> Score), 0, 5)." * 10^".(iconv_strlen(($jsonrez -> Top['4'] -> Score))-5)."\n\n".
            "Ваше место: ".($jsonrez -> MyPlace -> Place)."\n".
            "Ваши очки: ".($jsonrez -> MyPlace -> Score)
        ;

        return $return;

      }
      public function spincheck(){
        $url = "http://51.15.85.3/api/mobile/spinrewards?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $url2 = "http://51.15.85.3/api/mobile/time";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);
        $result = file_get_contents($url2, false, $context);
        $jsonrez2 = json_decode($result);


        $olddate = substr($jsonrez -> LastSpinDate, 0, -3);
        $newdate = substr($jsonrez2 -> Time, 0, -3);

        $hours = (($newdate - $olddate)/3600)%24;
        $min =  ( ( (($newdate - $olddate)/3600) - (($newdate - $olddate)/3600)%24 ) * 60 ) % 100;

        return "📆 Последний раз вы вращали колесо $hours ч. $min м. назад!\n";
      }
      public function balance(){
        $url = "http://51.15.85.3/api/mobile/validation?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $url2 = "http://51.15.85.3/api/mobile/getsitebalance?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $url3 = "http://51.15.85.3/api/mobile/getsoulprice?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);
        $result = file_get_contents($url2, false, $context);
        $jsonrez2 = json_decode($result);
        $result = file_get_contents($url3, false, $context);
        $jsonrez3 = json_decode($result);

        $price = $jsonrez3 -> SoulPrice;

        $return =
            "💼 Ваш баланс"."\n\n".
            "[в игре] : ".($jsonrez -> Balance)." SOUL / ".(($jsonrez -> Balance) * $price)." USD\n".
            "[на сайте] : ".($jsonrez2 -> SoulBalance)." SOUL / ".(($jsonrez2 -> SoulBalance) * $price)." USD\n\n".
            "Цена за SOUL: ".$price
        ;

        return $return;

      }
      public function btosite(){
        $url = "http://51.15.85.3/api/mobile/validation?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);

        $req = "http://51.15.85.3/api/mobile/hardtosoul?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22,%22Hard%22:".$jsonrez -> Balance."%7D";
        $result = file_get_contents($req, false, $context);


        $return =
            "Вы успешно отправили ".($jsonrez -> Balance)." SOUL на сайт!"
        ;

        return $return;

      }
      public function btogame(){
          $url = "http://51.15.85.3/api/mobile/getsitebalance?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22%7D";

          $options = array(
              'http' => array(
                  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                  'method'  => 'GET',

              )
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($url, false, $context);
          $jsonrez = json_decode($result);

          $req = "http://51.15.85.3/api/mobile/sitetogamedeposit?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22,%22Amount%22:".($jsonrez -> SoulBalance)."%7D";
          $result = file_get_contents($req, false, $context);


          $return =
              "Вы успешно отправили ".($jsonrez -> SoulBalance)." SOUL на баланс игры!"
          ;

          return $return;
      }
      public function spin($id){
        $url = "http://51.15.85.3/api/mobile/spin?key=".$this -> key."&appId=3&json=%7B%22Token%22:%22KmGCMIU_8vA6pw4zvJ-K1Q%5Cr%5Cn%22,%22Type%22:".$id."%7D";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',

            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsonrez = json_decode($result);

        $status = $jsonrez -> Status;
        $Key = $jsonrez -> Key;
        
       if ($status == 0){
           return "Поздрявляем! Вы выиграли $Key";
       } else{
           return "🚫 Упс... произошла ошибка:( ";
       }
      }


    }
  ?>