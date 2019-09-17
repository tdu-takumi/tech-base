<?php

// db connect
$mydb = '*****';
$myhost = 'localhost';
$dsn = 'mysql:dbname='.$mydb.';host='.$myhost;
$user = '*****';
$password = '*****';
$pdo = new PDO($dsn, $user, $password);

// 取得時間
date_default_timezone_set('Asia/Tokyo');

// 入力フォーム
$user = @$_POST["user"];
$comment = @$_POST["comment"];
$crypto = @$_POST["crypto"];
$edit_insert = @$_POST["edit_insert"];

function insert_form(){
  global $user;
  global $comment;
  global $crypto;
  global $edit_insert;
  global $pdo;

  // ファイルに保存
  if((strlen($comment) !== 0) and (strlen($user) !== 0)){
    $dt = date("Y-m-d H:i:s");
    if(strlen($edit_insert) === 0){
      $sql = $pdo -> prepare("INSERT INTO tbboard (name, comment, dt, password) VALUES (:user, :comment, :dt, :crypto)");
      $sql -> bindParam(':user', $user, PDO::PARAM_STR);
      $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
      $sql -> bindParam(':dt', $dt, PDO::PARAM_STR);
      $sql -> bindParam('crypto', $crypto, PDO::PARAM_STR);
      $sql -> execute();
    }
    elseif(strlen($edit_insert) !== 0){
      $sql = $pdo -> prepare("update tbboard set name=:user, comment=:comment where id=:edit_insert");
      $sql -> bindParam(":edit_insert", $edit_insert, PDO::PARAM_STR);
      $sql -> bindParam(":user", $user, PDO::PARAM_STR);
      $sql -> bindParam(":comment", $comment, PDO::PARAM_STR);
      $sql -> execute();
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
  global $delnum;
  global $delete_crypto;
  global $pdo;

  if((strlen($delnum) !== 0) and (strlen($delete_crypto) !== 0)){
    $sql = $pdo -> prepare("delete from tbboard where id=:delnum");
    $sql -> bindParam(':delnum', $delnum, PDO::PARAM_STR);
    $sql -> execute();
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

  global $pdo;

  if((strlen($editnum) !== 0) and (strlen($edit_crypto) !== 0)){
    // result[0][0] = password
    $sql = $pdo -> prepare("SELECT password FROM tbboard where id=:editnum");
    $sql -> bindParam(':editnum', $editnum, PDO::PARAM_STR);
    $sql -> execute();
    $result = $sql -> fetchAll();
    $password = $result[0][0];
    if($edit_crypto === $password){
      $sql2 = $pdo -> prepare("SELECT name, comment FROM tbboard where id=:editnum");
      $sql2 -> bindParam(':editname', $editnum, PDO::PARAM_STR);
      $sql2 -> execute();
      $results = $sql2 -> fetchAll();
      $editname = $results[0][0];
      $editcom = $results[0][1];
    }
  }
}
edit_form();


// ファイル内容を表示
function echo_file(){
  global $pdo;
  $sql = "SELECT * FROM tbboard";
  $stmt = $pdo->query($sql);
  $results = $stmt -> fetchAll();
  foreach($results as $row){
    echo $row["id"].". ";
    echo $row["name"]." ";
    echo $row["comment"]." ";
    echo $row["dt"]." ";
    echo $row["password"]."<br>";
    echo "<hr>";
  }
}

?>


<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>mission_5-1.php</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>mission_5-1.php</h1>
    <p>「名前」と「コメント」の入力フォームを用意し、<br>
      テキストファイルに「1投稿に付き1行」で保存しよう!</p>
    <p>テキストファイルを読み込み、フォームの直下に表示しよう！</p>
    <p>編集フォームから編集出来るようにしよう！</p>
    <p>パスワードを使って、編集削除をしよう！</p>
    <p>パスワードは半角英数字のみで入力してください。</p>

    <div class="content">
      <div class="form_box">
        <h1>入力フォーム/削除フォーム/編集フォーム</h1>
        <form action="mission_5-1.php" method="post">
          <div class="insert_form">
            <input type="text" name="user" placeholder="名前" value="<?php echo $editname; ?>"><br>
            <input type="text" name="comment" placeholder="コメント" value="<?php echo $editcom; ?>"><br>
            <input type="password" name="crypto" placeholder="password" pattern="[a-zA-Z0-9]+">
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
