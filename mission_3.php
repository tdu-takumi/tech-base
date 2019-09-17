<?php

// mission_3

$filename = "mission_3.txt";

// 入力フォーム
$user = @$_POST["user"];
$comment = @$_POST["comment"];
$crypto = @$_POST["crypto"];
$edit_insert = @$_POST["edit_insert"];

function insert_form(){
  global $filename;
  global $user;
  global $comment;
  global $crypto;
  global $edit_insert;

  $arr = file($filename, FILE_SKIP_EMPTY_LINES);
  $arrlen = count($arr);
  $initnum = 1;
  if($arrlen !== 0){
    $arrexplode = explode("<>", $arr[$arrlen - 1]);
    $initnum = $arrexplode[0] + 1;
  }

  // ファイルに保存
  if((strlen($comment) !== 0) and (strlen($user) !== 0)){
    date_default_timezone_set('Asia/Tokyo');
    $setdate = date("Y年m月d日 H時i分s秒");
    if(strlen($edit_insert) === 0){
      $comment = $initnum."<>".$user."<>".$comment."<>".$setdate."<>".$crypto."<>"."\r\n";
      $fp = fopen($filename, "a");
      fwrite($fp, $comment);
      fclose($fp);
    }
    elseif(strlen($edit_insert) !== 0){
        $comment = $edit_insert."<>".$user."<>".$comment."<>".$setdate."<>".$crypto."<>"."\r\n";
        $fp = fopen($filename, "w");
        foreach($arr as $var){
          $parts = explode("<>", $var);
          if(($parts[0] === $edit_insert) and ($parts[4] === $crypto)){
            $var = $comment;
          }
          fwrite($fp, $var);
        }
        fclose($fp);
     }
     else{
       echo "error";
     }
  }
}
insert_form();


// 削除フォーム
$delnum = @$_POST["delnum"];
$delete_crypto = @$_POST["delete_crypto"];

function delete_form(){
  global $filename;
  global $delnum;
  global $delete_crypto;

  if((strlen($delnum) !== 0) and (strlen($delete_crypto) !== 0)){
    $arr = file($filename, FILE_SKIP_EMPTY_LINES);
    $fp = fopen($filename, "w");
    foreach($arr as $var){
      $parts = explode("<>", $var);
      if(($parts[0] === $delnum) and ($parts[4] === $delete_crypto)){
        $var = "";
      }
      fwrite($fp, $var);
    }
    fclose($fp);
  }
}
delete_form();


// 編集フォーム
$editnum = @$_POST["editnum"];
$edit_crypto = @$_POST["edit_crypto"];
$edtiname = "";
$editcom = "";

function edit_form(){
  global $editnum;
  global $edit_crypto;

  global $editname;
  global $editcom;

  if((strlen($editnum) !== 0) and (strlen($edit_crypto) !== 0)){
    $arr = file($filename, FILE_SKIP_EMPTY_LINES);
    foreach($arr as $var){
      $parts = explode("<>", $var);
      if(($parts[0] === $editnum) and ($parts[4] === $edit_crypto)){
        $editname = $parts[1];
        $editcom = $parts[2];
        $edit_crypto = $parts[4];
      }
    }
  }
}
edit_form();


// ファイル内容を表示
function echo_file(){
  global $filename;
  $contents = file($filename, FILE_SKIP_EMPTY_LINES);
  foreach($contents as $var){
    $parts = explode("<>", $var);
    foreach($parts as $value){
      echo $value."  ";
    }
    echo "<br>";
  }
}


?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>mission_3.php</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>mission_3.php</h1>
    <p>「名前」と「コメント」の入力フォームを用意し、<br>
      テキストファイルに「1投稿に付き1行」で保存しよう!</p>
    <p>テキストファイルを読み込み、フォームの直下に表示しよう！</p>
    <p>編集フォームから編集出来るようにしよう！</p>
    <p>パスワードを使って、編集削除をしよう！</p>
    <p>パスワードは半角英数字のみで入力してください。</p>

    <div class="content">
      <div class="form_box">
        <h1>入力フォーム/削除フォーム/編集フォーム</h1>
        <form action="mission_3.php" method="post">
          <div class="insert_form">
            <input type="text" name="user" placeholder="名前" value="<?php echo $editname; ?>"><br>
            <input type="text" name="comment" placeholder="コメント" value="<?php echo $editcom; ?>"><br>
            <input type="password" name="crypto" placeholder="password" value="<?php echo $edit_crypto; ?>" pattern="[a-zA-Z0-9]+">
            <input class="submit_button" type="submit" value="送信">
          </div>
          <div class="delete_form">
            <input type="number" name="delnum" placeholder="投稿番号"><br>
            <input type="password" name="delete_crypto" placeholder="password" pattern="[a-zA-Z0-9]+">
            <input class="submit_button" type="submit" value="削除">
          </div>
          <div class="edit_form">
            <input type="hidden" name="edit_insert">
            <input type="number" name="editnum" placeholder="投稿番号"><br>
            <input type="password" name="edit_crypto" placeholder="password" pattern="[a-zA-Z0-9]+">
            <input class="submit_button" type="submit" value="編集">
          </div>
        </form>
        <br>
        <hr>
        <h2>ファイル内容</h2>
        <?php echo_file(); ?>
      </div>
    </div>

  </body>
</html>
