<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- /JQuery -->

    <!-- BingMaps -->
    <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AijSU_gfuOo18dgo6sDTtJ0GCCj0tKghXHzQgwF5ZAvEU-EdC6D654uArRIF0TLq' async defer></script>
    <script src="./js/BmapQuery.js"></script>
    <!-- /BingMaps -->

    <!-- OnsenUI -->
    <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
    <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsen-css-components.min.css">
    <script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>
    <!-- /OnsenUI -->
    
    <title>あなたの位置を登録しよう！</title>
</head>

<body>
<div id="myMap" style='position:relative;width:100%;height:100%;'></div>

<script>
    //Maps Init
    function GetMap() {
        let map = new Microsoft.Maps.Map('#myMap', {
          <?php
$myfile = fopen("./data/mydata.txt","r");
$mystr_base = fgets($myfile);
$mystr = explode(",",$mystr_base);
$lat1 = $mystr[0];
$lon1 = $mystr[1];
echo "center: new Microsoft.Maps.Location(".$lat1.", ".$lon1."),";
?>
            zoom: 13
        });

        //Set:Infobox
        let location = map.getCenter();
        let infobox = new Microsoft.Maps.Infobox(location, {
            title: 'あなたがいる場所',
            description: 'ここです'
        });
        infobox.setMap(map);

<?php

$file = fopen("./data/data.txt","r");
$myfile = fopen("./data/mydata.txt","r");
$mystr_base = fgets($myfile);
$mystr = explode(",",$mystr_base);
$lat1 = $mystr[0];
$lon1 = $mystr[1];
$mysex = $mystr[2];
$count = 0;

// whileで行末までループ処理
while (!feof($file)) {
 
  // fgetsでファイルを読み込み、変数に格納
  $str_base = fgets($file);
  $str = explode(",",$str_base);
  $date = $str[0];
  $name = $str[1];
  $mail = $str[2];
  $lat2 = $str[3];
  $lon2 = $str[4];
  $sex = $str[5];

  // 緯度経度をラジアンに変換
  $radLat1 = deg2rad($lat1); // 緯度１
  $radLon1 = deg2rad($lon1); // 経度１
  $radLat2 = deg2rad($lat2); // 緯度２
  $radLon2 = deg2rad($lon2); // 経度２

  // 緯度差
  $radLatDiff = $radLat1 - $radLat2;

  // 経度差算
  $radLonDiff = $radLon1 - $radLon2;

  // 平均緯度
  $radLatAve = ($radLat1 + $radLat2) / 2.0;

  // 測地系による値の違い
  $a = $mode ? 6378137.0 : 6377397.155; // 赤道半径
  $b = $mode ? 6356752.314140356 : 6356078.963; // 極半径
  //$e2 = ($a*$a - $b*$b) / ($a*$a);
  $e2 = $mode ? 0.00669438002301188 : 0.00667436061028297; // 第一離心率^2
  //$a1e2 = $a * (1 - $e2);
  $a1e2 = $mode ? 6335439.32708317 : 6334832.10663254; // 赤道上の子午線曲率半径

  $sinLat = sin($radLatAve);
  $W2 = 1.0 - $e2 * ($sinLat*$sinLat);
  $M = $a1e2 / (sqrt($W2)*$W2); // 子午線曲率半径M
  $N = $a / sqrt($W2); // 卯酉線曲率半径

  $t1 = $M * $radLatDiff;
  $t2 = $N * cos($radLatAve) * $radLonDiff;
  $dist = sqrt(($t1*$t1) + ($t2*$t2));
  
  $count = $count + 1;

  if (is_null($name)) {
  }elseif ($sex !== $mysex) {
    //Set:Infobox
    echo "let location".$count." = new Microsoft.Maps.Location(".$lat2.", ".$lon2.");";
    echo "let infobox".$count." = new Microsoft.Maps.Infobox(location".$count.", {";
    echo "title: '".$name."',";
    echo "description:'距離:".$dist."メートル<br>メール:".$mail."<br>登録日時:".$date."'";
    echo "});";
    echo "infobox".$count.".setMap(map);";
  }
}
 
// fcloseでファイルを閉じる
fclose($file);
?>

      }
</script>

</body>

</html>