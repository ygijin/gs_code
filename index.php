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

    <!-- Map制御 -->
    <script>
    //1．位置情報の取得に成功した時の処理
    function mapsInit(position) {
        //lat=緯度、lon=経度 を取得
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        document.getElementById('lat').value = lat;
        document.getElementById('lon').value = lon;
        const map = new Bmap("#myMap");
        map.startMap(lat,lon,"aerial",16);
        let pin = map.pin(lat,lon, "#ff0000");
    };

    //2． 位置情報の取得に失敗した場合の処理
    function mapsError(error) {
      let e = "";
      if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
        e = "位置情報が許可されてません";
      }
      if (error.code == 2) { //2＝現在地を特定できない
        e = "現在位置を特定できません";
      }
      if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
        e = "位置情報を取得する前にタイムアウトになりました";
      }
      alert("エラー：" + e);
    };

    //3.位置情報取得オプション
    let set ={
      enableHighAccuracy: true, //より高精度な位置を求める
      maximumAge: 20000,        //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
      timeout: 10000            //10秒以内に現在地情報を取得できなければ、処理を終了
    };

    //Main:位置情報を取得する処理 //getCurrentPosition :or: watchPosition
    function GetMap() {
      navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);
    }
    </script>
    <!-- /Map制御 -->

    <!-- OnsenUI -->
    <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
    <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsen-css-components.min.css">
    <script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>
    <!-- /OnsenUI -->
    
    <title>あなたの位置を登録しよう！</title>
</head>

<body>
<!-- MapArea -->
<div class="card card--material" id="view">
<form action="write.php" method="post">
<div><input type="text" class="text-input" placeholder="お名前" value="" name="name"></div>
<div><input type="text" class="text-input" placeholder="メールアドレス" value="" name="mail"></div>
<div><input type="text" class="text-input" placeholder="緯度" value="" name="lat" id="lat"></div>
<div><input type="text" class="text-input" placeholder="経度" value="" name="lon" id="lon"></div>
  <label class="radio-button radio-button--material">
    <input type="radio" class="radio-button__input radio-button--material__input" value="m" name="sex">
    <div class="radio-button__checkmark radio-button--material__checkmark"></div>
    男性
  </label>
  <label class="radio-button radio-button--material">
    <input type="radio" class="radio-button__input radio-button--material__input" value="f" name="sex">
    <div class="radio-button__checkmark radio-button--material__checkmark"></div>
    女性
  </label>
  <button class="button" type="submit">登録</button>
</form>
</div>
<div id="myMap" style='position:relative;width:100%;height:100%;'></div>
<!-- /MapArea -->
</body>

</html>