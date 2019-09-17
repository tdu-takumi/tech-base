<?php

// mission_2-1 ~ mission_2-4
// formから送信して、内容をファイルに保存
// ファイルから1行づつ表示

// filename
$filename = "mission_2.txt";

$comment = @$_POST["comment"];

// save
if(strlen($comment) !== 0){
  $fp = fopen($filename, "a");
  $comment = $comment."\r\n";
  fwrite($fp, $comment);
  fclose($fp);
}


// echo file contents
function echo_contents(){
  global $filename;
  $arr = file($filename, FILE_SKIP_EMPTY_LINES);
  foreach($arr as $var){
    echo $var."<br>";
  }
}


?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>mission_2</title>
  </head>
  <body>
    <h1>フォーム</h1>
    <form action="mission_2.php" method="post">
      <input type="text" name="comment" placeholder="コメント">
      <input type="submit" value="送信">
    </form>
    <hr>
    <h1>ファイルの内容</h1>
    <?php echo_contents(); ?>
  </body>
</html>
