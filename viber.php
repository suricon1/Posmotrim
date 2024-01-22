<?php
//
//function send_message($receiverID, $TextMessage)
//{
//
//    $curl = curl_init();
//    $json_data = '{
//"receiver":"' . $receiverID . '",
//"min_api_version":1,
//"sender":{
//"name":"NameBot",
//"avatar":"avatar.example.com"
//},
//"tracking_data":"tracking data",
//"type":"text",
//"text":"' . $TextMessage . '"
//}
//';
//    $data = json_decode($json_data); // Преобразовываем в json код
//
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => "https://chatapi.viber.com/pa/send_message",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "POST",
//        CURLOPT_POSTFIELDS => json_encode($data), // отправка кода
//
//        CURLOPT_HTTPHEADER => array(
//            "Cache-Control: no-cache",
//            "Content-Type: application/JSON",
//            "X-Viber-Auth-Token: 522592c398e7e221-8541d5fc695fd2c7-5cd6c114a0ec1d11"
//        ),
//    ));
//
//    $response = curl_exec($curl);
//    $err = curl_error($curl);
//
//    curl_close($curl);
//
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response;
//    }
//}
//
//// сообщение в viber
//send_message('+375296876515', 'Привет Это бот!');
////send_message('yI8UmH+jb9ZAzyYtU/mYwg==', 'Привет Это бот!');
//
//
//// #########################
//
//class Viber
//{
//    private $url_api = "https://chatapi.viber.com/pa/";
//
//    private $token = "522592c398e7e221-8541d5fc695fd2c7-5cd6c114a0ec1d11";
//
//    public function message_post
//    (
//        $from,          // ID администратора Public Account.
//        array $sender,  // Данные отправителя.
//        $text           // Текст.
//    )
//    {
//        $data['from']   = $from;
//        $data['sender'] = $sender;
//        $data['type']   = 'text';
//        $data['text']   = $text;
//        return $this->call_api('post', $data);
//    }
//
//    private function call_api($method, $data)
//    {
//        $url = $this->url_api.$method;
//
//        $options = array(
//            'http' => array(
//                'header'  => "Content-type: application/x-www-form-urlencoded\r\nX-Viber-Auth-Token: ".$this->token."\r\n",
//                'method'  => 'POST',
//                'content' => json_encode($data)
//            )
//        );
//        $context  = stream_context_create($options);
//        $response = file_get_contents($url, false, $context);
//        return json_decode($response);
//    }
//}
//$Viber = new Viber();
//$Viber->message_post(
//    '01234567890A=',
//    [
//        'name' => 'Admin', // Имя отправителя. Максимум символов 28.
//        'avatar' => 'http://avatar.example.com' // Ссылка на аватарку. Максимальный размер 100кб.
//    ],
//    'Test'
//);
//
//
////function send_message_viber($api_key, $message, $group = '') {
////    static $ch = null;
////    $post_data =  http_build_query( array('key'=>$api_key, 'text'=>$message, 'grp'=>$group), '', '&');
////    if (is_null($ch)) {
////        $ch = curl_init();
////        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
////        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; PHP client; ' . php_uname('s') . '; PHP/' . phpversion() . ')');
////    }
////    curl_setopt($ch, CURLOPT_URL, 'http://notify24.ru/api/send/viber');
////    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
////    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
////    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
////    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
////    $res = curl_exec($ch);
////    if (!$res  || !$json = json_decode($res, true)) {
////        return false;
////    }
////    return $json;
////}
//
//
//
//public function viber_send()
//{
//    $this->send_message('+375296876515', 'Привет Это бот!');
//}
//
//public function webhook()
//{
//    $auth_token = '5225ad36af27dd74-3d33b5837b342d3e-46082d3d29c7c1d0';
//    $webhook = 'https://vinograd-minsk.by/admin/vinograd/orders/viber_send';
//
//    $jsonData =
//        '{
//                "auth_token": "'.$auth_token.'",
//                "url": "'.$webhook.'",
//                "event_types": ["subscribed", "unsubscribed", "delivered", "message", "seen"]
//            }';
//
//    $ch = curl_init('https://chatapi.viber.com/pa/set_webhook');
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//    $response = curl_exec($ch);
//    $err = curl_error($ch);
//    curl_close($ch);
//    if($err) {echo($err);}
//    else {echo($response);}
//}
//
//private function send_message($receiverID, $TextMessage)
//{
//    $curl = curl_init();
//    $json_data = '{
//                "receiver":"' . $receiverID . '",
//                "min_api_version":1,
//                "sender":{
//                "name":"NameBot",
//                "avatar":"avatar.example.com"
//                },
//                "tracking_data":"tracking data",
//               "type":"text",
//                "text":"' . $TextMessage . '"
//                }
//                ';
//    $data = json_decode($json_data); // Преобразовываем в json код
//
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => "https://chatapi.viber.com/pa/send_message",
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => "",
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 30,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => "POST",
//        CURLOPT_POSTFIELDS => json_encode($data), // отправка кода
//
//        CURLOPT_HTTPHEADER => array(
//            "Cache-Control: no-cache",
//            "Content-Type: application/JSON",
//            "X-Viber-Auth-Token: 5225ad36af27dd74-3d33b5837b342d3e-46082d3d29c7c1d0"
////                    "X-Viber-Auth-Token: 522592c398e7e221-8541d5fc695fd2c7-5cd6c114a0ec1d11"
//        ),
//    ));
//
//    $response = curl_exec($curl);
//    $err = curl_error($curl);
//
//    curl_close($curl);
//
//    if ($err) {
//        echo "cURL Error #:" . $err;
//    } else {
//        echo $response;
//    }
//}
//
