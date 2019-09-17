<?php

// mission_1-1
echo "misson_1-1<br>";
echo "Hello World.";  // 文字列の表示
echo "<br>";
echo "Hello"." "."World.";  // 文字列の連結
echo "<br>";
echo 2019;  // 数字の表示
echo "<br>";
$word = "Hello World.";
$num = 2019;
echo $word.$num;  // 文字列と数字の連結
echo "<hr>";


// mission_1-2 and mission_1-3
// wモードでファイルを開いて書き込む。ファイルの中身を表示
echo "misson_1-2 and mission_1-3 [w mode]<br>";
$word = "Hello World\r\n";
$filename = "mission_1-2.txt";
$fp = fopen($filename, "w");
fwrite($fp, $word);
fclose($fp);
$arr = file($filename, FILE_SKIP_EMPTY_LINES);
foreach($arr as $var){
  echo $var."<br>";
}
echo "<hr>";

// aモードでファイルを開いて書き込む。ファイルの中身を表示
echo "mission_1-2 and mission_1-3 [a mode]<br>";
$word2 = "Good Night\r\n";
$fp = fopen($filename, "a");
fwrite($fp, $word2);
fclose($fp);
$arr = file($filename, FILE_SKIP_EMPTY_LINES);
foreach($arr as $var){
  echo $var."<br>";
}
echo "<hr>";


// mission_1-4
echo "mission_1-4<br>";
echo 2019-1998;  // 今年から誕生年を引いて年齢を表示
echo "<br>";
echo 20+12;  // 1回り上の年齢を表示
echo "<br>";
echo 20 + 12*2;  // 2周り上の年齢を表示
echo "<br>";
$thisyear = 2019;
$mybirth = 1998;
$amari = ($thisyear - $mybirth) % 4;
echo ($thisyear - $mybirth - $amari) / 4;  // 生まれてから夏季オリンピックを何回過ごしたか
echo "<br>";
echo "<hr>";

// mission_1-5
echo "mission_1-5<br>";
// if,elseif,else文の使い方
$age = 20;
if($age >= 85){
  echo "免許を返納しませんか？";
}elseif($age >= 18){
  echo "自動車免許が取れます。";
}else{
  echo "自動車免許はまだ取得できません。";
}
echo "<br>";
echo "<hr>";


// mission_1-6
echo "mission_1-6";
echo "<br>";
// 夏季オリンピックが開催された年
$start_year = 2000;
$now_year = 2019;
for($i = $start_year; $i <= $now_year; $i=$i+4){
  echo $i."<br>";
}
echo "<br>";
//  配列から「ごりら」を表示
$shiritori = array("しりとり", "りんご", "ごりら", "らっこ", "こあら", "らくだ");
echo $shiritori[2]."<br>";
echo "<br>";
//  foreach文による配列専用のfor文
$ankiword = "";
foreach($shiritori as $var){
  $ankiword = $ankiword.$var;
  echo $ankiword."<br>";
}


?>
