<?php
echo"dsds";

include 'minilib.php';
function run(){
  $arr = file_get_contents('php://input');
	$data = json_decode($arr, true);
  file_put_contents('info/message.json',$arr);
 

  $bot = new bot("1618755473:AAHoWQLqmguqUsf83OMKbEEOgbMTMlV7rt4");
  $bot -> update($data);
  $cryptosoul = new cryptosoul("m9DeeAgkJPPvGWwuQmGTB6ZcKYAYakQp");
  
  if(!empty($bot->d_text)){
    switch($bot->d_text){
      case "/start":{
        $text = "Добрый день!\nРады приветствовать вас в телеграм версию игры MergeCat. Используйте кнопки для дальнейшей навигации";
        $buttons = array(
          array(
            '💼Аккаунт',
            '📦LootBox-ы',
            '🎰Spin'
          ),
          array(
            '💰Баланс',
            '🏆Рейтинг',
            '❔Помощь'
          ),
          array(
            '🔑Сменить API-key'
          )
        );
        $keyb = keyboard(json_encode($buttons), 'true', 'false', 'false');
        $bot -> send_keyb($bot -> d_chatid, $text,$keyb);
        break;
      }
      case "📦LootBox-ы":{
        $buttons = [
          array(
            array(
            'text' => '📦Открыть Free capsule',
            'callback_data' => 'Free'
            ),
            array(
              'text' => '💰Открыть Iron capsule',
              'callback_data' => 'Iron'
            )
          ),
          array(
            array(
            'text' => '👑Открыть Golden capsule',
            'callback_data' => 'Golden'
            ),
            array(
              'text' => '💎Открыть Diamond capsule',
              'callback_data' => 'Diamond'
            )
          )
        ];
      
        $text = $cryptosoul -> aviablelb();
        $buttons = array("inline_keyboard"=>$buttons);
        $bot -> send_keyb($bot -> d_chatid, $text, json_encode($buttons));
        break;
      }
      case "💼Аккаунт":{
        $text = $cryptosoul -> account();
        $bot -> send($bot -> d_chatid, $text);
        break;
      }
      case "❔Помощь":{
        $text = "С чем вам нужна помощь?";
        $buttons = [
            array(
              array(
              'text' => '❔Вывод',
              'callback_data' => 'helpwithdraw'
              ),
              array(
              'text' => '❔Кошельки',
              'callback_data' => 'helpwall'
              )
            ),
            array(
              array(
              'text' => '❔Адресс контракта',
              'callback_data' => 'helpcont'
              ),
              array(
              'text' => '❔Обмен',
              'callback_data' => 'helpexch'
              )
            )
          ];
          $buttons = array("inline_keyboard"=>$buttons);
          $bot -> send_keyb($bot -> d_chatid, $text, json_encode($buttons));
        break;
      }
      case "🏆Рейтинг":{
        $text = $cryptosoul -> top();
        $bot -> send($bot -> d_chatid, $text);
        break;
      }
      case "🎰Spin":{
        $text = $cryptosoul -> spincheck();

        $buttons = [[
          array(
            'text' => 'Вращать колесо',
            'callback_data' => 'spin'
          ),
          array(
            'text' => 'Вращать за 18 SOUL',
            'callback_data' => 'spin18'
          )
          
        ]];
        $buttons = array("inline_keyboard"=>$buttons);
        $bot -> send_keyb($bot -> d_chatid, $text, json_encode($buttons));

        break;
      }
      case "💰Баланс":{
        $text = $cryptosoul -> balance();

        $buttons = [
          array(
            array(
            'text' => 'баланс игры => баланс сайта',
            'callback_data' => 'tosite'
          )
          ),
          array(
            array(
            'text' => 'баланс сайта => баланс игры',
            'callback_data' => 'togame'
          )
          )
        ];
        $buttons = array("inline_keyboard"=>$buttons);
        $bot -> send_keyb($bot -> d_chatid, $text, json_encode($buttons));


        break;
      }
    }
  }

  if(!empty($bot->d_cbdata)){
    switch ($bot->d_cbdata){
      case "Free" :{
        $text = $cryptosoul -> openlootbox(1);
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "Iron" :{
        $text = $cryptosoul -> openlootbox(2);
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "Golden" :{
        $text = $cryptosoul -> openlootbox(3);
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "Diamond" :{
        $text = $cryptosoul -> openlootbox(4);
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "tosite" :{
        $text = $cryptosoul -> btosite();
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "togame" :{
        $text = $cryptosoul -> btogame();
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "spin" :{
        $text = $cryptosoul -> spin(0);
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "spin18" :{
        $text = $cryptosoul -> spin(1);
        $bot -> send($bot -> d_cbid, $text);
        break;
      }
      case "helpcont" :{
        $text = "ℹ Если кошелек не видит SOUL токен:

Contract: <code>0xbb1f24c0c1554b9990222f036b0aad6ee4caec29</code>
Decimals: <code>18</code>
Symbol: <code>SOUL</code>

Внимание! Не все кошельки поддерживают SOUL токен ";
        $bot -> send_html($bot -> d_cbid, $text);
        break;
      }
      case "helpexch" :{
        $text = 'ℹ Биржы на которых вы сможете обменять свои токены: 

✅ <a href="https://www.binance.org/en/trade/mini/SOUL-D11M_BNB">Binance</a>
✅ <a href="https://app.uniswap.org/#/swap?inputCurrency=0xbb1f24c0c1554b9990222f036b0aad6ee4caec29&outputCurrency=ETH">Uniswap</a>
✅ <a href="https://www.hotbit.io/exchange?symbol=CSOUL_USDT">HotBit</a>
✅ <a href="https://mercatox.com/exchange/SOUL/ETH">Mercatox</a>

';
        $bot -> send_html($bot -> d_cbid, $text);
        break;
      }
      case "helpwall" :{
        $text = 'ℹ Для вывода рекомендуем данные кошельки: 

✅ <a href="https://metamask.io/download.html">Metamask</a>
✅ <a href="https://token.im/">ImToken</a>
✅ <a href="https://trustwallet.com/">TrustWallet</a>
✅ <a href="https://eidoo.io/">Eidoo</a>
✅ <a href="https://www.myetherwallet.com">MyEtherWallet</a>

';
        $bot -> send_html($bot -> d_cbid, $text);
        break;
      }
      case "helpwithdraw" :{
        $text = 'ℹ Полную инструкцию вывода вы можете найти <a href="https://cryptosoul.io/ru/how-to-withdraw-soul">здесь</a>';
        $bot -> send_html($bot -> d_cbid, $text);
        break;
      }
    }

  }


  if($bot->d_text == 'keyb'){
    $buttons = array(
      array(
        'Информация'
      ),
      array(
        'Отзыв'
      )
    );
    $keyb = keyboard(json_encode($buttons), 'true', 'false', 'false');
    $bot -> send_keyb($bot -> d_chatid, "hell", $keyb);
    
  }

  if($bot->d_text == 'inkeyb'){
    $buttons = [[
      array(
        'text' => 'Информация',
        'callback_data' => 'm'
      ),
      array(
        'text' => 'Отзыв',
        'callback_data' => 'b'
      ),
    ]];
    $buttons = array("inline_keyboard"=>$buttons);
    $bot -> send_keyb($bot -> d_chatid, "hell", json_encode($buttons));
    
  }

}
run();
?>
