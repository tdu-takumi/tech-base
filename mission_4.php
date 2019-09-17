<?php

// mission_4
// connect db
$mydb = '*****';
$myhost = '*****';
$dsn = 'mysql:dbname='.$mydb.';host='.$myhost;
$user = '*****';
$password = '*****';
$pdo = new PDO($dsn, $user, $password);
echo "mission_4-1 OK<br>";
echo "<hr>";

// create table
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT"
.");";
$stmt = $pdo->query($sql);
echo "mission_4-2 OK<br>";
echo "<hr>";


// show table テーブル一覧
$sql = "SHOW TABLES";
$result = $pdo -> query($sql);
foreach($result as $row){
  echo $row[0];
  echo '<br>';
}
echo "mission_4-3 OK<br>";
echo "<hr>";


// テーブルの詳細
$sql = 'SHOW CREATE TABLE tbtest';
$result = $pdo -> query($sql);
foreach($result as $row){
  echo $row[1];
}
echo "mission_4-4 OK";
echo "<hr>";


// insert
$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$name = 'python name';
$comment = 'python comment';
$sql -> execute();
echo "mission_4-5 OK<br>";
echo "<hr>";


// select
$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt -> fetchAll();
foreach($results as $row){
  echo $row["id"].",";
  echo $row["name"].",";
  echo $row["comment"]."<br>";
}
echo "mission_4-6 OK<br>";
echo "<hr>";


// update
$id = 1;
$name = "PHP name";
$comment = "PHP comment";
$sql = "update tbtest set name=:name, comment=:comment where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
$stmt->execute();
echo "mission_4-7 OK<br>";
echo "<hr>";


// delete
$id = 1;
$sql = "delete from tbtest where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
echo "mission_4-8 OK<br>";
echo "<hr>";


?>
