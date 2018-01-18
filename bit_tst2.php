<?php

//コインチェックのサイトのパブリックＡＰＩを利用して、取引値などを取得して数秒ごとに画面に表示させる。test6:30

//PEARのHTTP_Requestをインクルードする
require_once "HTTP/Request3.php"; //request3 を　requestに戻すこと
 
//HTTP_RequestするURL
$http_request_url = "https://coincheck.com/api/trades2"; //trades2に戻すこと
 
//HTTP_Requestのオプション指定
$http_request_option = array(
    "timeout" => "10",       // タイムアウトの秒数指定
    "allowRedirects" => true,    // リダイレクトの許可設定(true/false)
    "maxRedirects" => 3, // リダイレクトの最大回数
);
 
//HTTP_Requestの初期化
$http = new HTTP_Request($http_request_url, $http_request_option);
 
//HTTPヘッダーの設定
$http->addHeader("User-Agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36"); //ユーザーエージェントの設定
$http->addHeader("Referer", "http://seo-55up.com/bitcoin2/coincheck-php-master/bit_tst2.php");   //参照元の設定
$http->addHeader("Authorization", ""); //HTTPアクセス認証の設定（不必要であれば削除）
 
//メソッドの設定
$http->setMethod(HTTP_REQUEST_METHOD_GET);
 
//POST送信の設定（不必要であれば削除）
  //POST送信するデータ
  $post_data = array('ここに名前' => 'ここにPOST送信するデータ');
  //メソッドがPOST送信か確認する
//  if ($http->_method == HTTP_REQUEST_METHOD_POST) {
//    foreach ($post_data as $key => $value){
//        $http->addPostData($key, $value);
//    }
//  }

//ベーシック認証の設定（不必要であれば削除）
//$http->setBasicAuth("名前", "パスワード");
 
//Cookieの設定（不必要であれば削除）
//$http->addCookie("Cookieの名前", "値");
 
//プロキシの設定（不必要であれば削除）
//$http->setProxy("proxy.example.com", 8080);
 
//プロキシに対する認証（不必要であれば削除）
//$http->setProxy("proxy.example.com", 8080, "名前", "パスワード");

$cnt=0;

//数秒おきにhttpリクエスをとして、画面表示させる
for($cnt=0; $cnt<100;$cnt++){
	//HTTPリクエストの実行
	$response = $http->sendRequest();
 
	//HTTPリクエストが成功したか確認
	if (PEAR::isError($response)){
    		//エラー文出力
    		echo $response->getMessage();
	}else{
    		//ResponseCode(200等)を取得 
    		$response_code = $http->getResponseCode();
  		//ResponseHeader(レスポンスヘッダ)を取得
 		$response_header = $http->getResponseHeader();
    		//コンテンツを取得
    		$response_body = $http->getResponseBody();
    		//クッキーを取得
    		$resposen_cookie = $http->getResponseCookies();
	}
 
	$csv = array(); 
	$csv1 = array(); 
	$h = 0; 
	$i = 0;
	$value = "";
	$value2 = array();

	//リクエストが成功した場合
	if($response_code === 200){
    		//コンテンツの出力
    		//echo $response_body;
		//コインチェックからのリターンを１レコードづつとりだす。
		$csv = explode("},{",$response_body);
		//echo "<br />--------<br />";
		//echo $csv[0];
		//取り出したレコードをさらに、カンマ毎にデータを分ける。多次元配列とな
		foreach ($csv as $value){
			$csv2[$h] = explode(",",$value); //多次元配列
			$h++;
		}
		echo "<br />--------<br />";
		//取得した2次元配列のデータを必要な部分のみ抽出する
		for($i=0; $i < $h; $i++){
			echo $csv2[$i][2];
			echo "<br />";
			echo $csv2[$i][3];
			echo "<br />";
		
		}
	//デバック用コード
	//echo "<br />--------<br />";
	//echo $csv2[3][0];

	}
	sleep(1);
}

?>
