<head>
<meta charset="utf-8">
<title>File書き込み</title>
</head>
<body>
書き込みを行います。
<?php
//関数郡を読み込む
include ("./funcs.php");
//文字作成
$date = date("Y-m-d H:i:s");
$name = h($_POST["name"]);
$mail = h($_POST["mail"]);
$lat = h($_POST["lat"]);
$lon = h($_POST["lon"]);
$sex = h($_POST["sex"]);
$c = ",";
$str = $date.$c.$name.$c.$mail.$c.$lat.$c.$lon.$c.$sex;

//File書き込み
$file = fopen("./data/data.txt","a");
fwrite($file, $str."\n");
fclose($file);

$myfile = fopen("./data/mydata.txt","w");
fwrite($myfile, $lat.",".$lon.",".$sex."\n");
fclose($myfile);
?>

<a href="./read.php">ここをクリックして近い人をチェック</a>

</body>
</html>