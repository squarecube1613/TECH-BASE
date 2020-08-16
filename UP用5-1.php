<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_5-1</title>
</head>
<body>
<?php
//データベース接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//データ入力(3-1+(3-4)+4-5)
if(empty($_POST["name"])==false&&empty($_POST["comment"])==false&&empty($_POST["number"])==true){
	$sql = $pdo -> prepare("INSERT INTO board (name, comment,pass) VALUES (:name, :comment, :pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$pass = $_POST["pass"];
	$sql -> execute();
}
//編集選択(3-4-1)
if(!empty($_POST["edit"])){
    $id=$_POST["edit"];
 	$sql = 'SELECT * FROM board where id=:id';
 	$stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
 	$stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
    $stmt->execute();                             // ←SQLを実行する。
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($row['pass']==$_POST["passe"]){
		$editnum=$row['id'];
		$editnam=$row['name'];
		$editcom=$row['comment'];
		$editpass=$row['pass'];
		}
	}
}
//編集(3-4+4-7)
if(empty($_POST["name"])==false&&empty($_POST["comment"])==false&&empty($_POST["number"])==false){
	$id = $_POST["number"]; 
	$name = $_POST["name"];
	$comment = $_POST["comment"]; 
	$pass = $_POST["pass"];
	$sql = 'UPDATE board SET name=:name,comment=:comment,pass=:pass where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}
?>
<form method="POST" action="">
        <input type="text" name="name" placeholder="名前" value=<?php if(isset($editnam)){echo$editnam;}?>> <br>
        <input type="text" name="comment" placeholder="コメント" value=<?php if(isset($editcom)){echo$editcom;}?>> <br>
        <input type="text" name="pass" placeholder="パスワード" value=<?php if(isset($editpass)){echo$editpass;}?>>
        <input type="hidden" name="number" value=<?php if(isset($editnum)){echo$editnum;}?>>
        <input type="submit" name="submit" value="送信"><br><br>
</form>
<form method="POST" action="">
        <input type="text" name="delete" placeholder="削除番号"><br>
        <input type="text" name="passd" placeholder="パスワード">
        <input type="submit" name="submit" value="削除"><br><br>
</form>
<form method="POST" action="">
        <input type="text" name="edit" placeholder="編集番号"><br>
        <input type="text" name="passe" placeholder="パスワード">
        <input type="submit" name="submit" value="編集"><br><br>
</form>   
<?php
//削除(4-8)
if(!empty($_POST["delete"])){
	$id = $_POST["delete"];
	$sql = 'SELECT * FROM board where id=:id';
	$stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
 	$stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
    $stmt->execute();                             // ←SQLを実行する。
	$results = $stmt->fetchAll();
	foreach ($results as $row){
	if($row['pass']==$_POST["passd"]){
    	$sql = 'delete from board where id=:id';
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    	$stmt->execute();
    	}
}
}
//データ表示(4-6)	
	$sql = 'SELECT * FROM board';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	echo "<hr>";
	}
?>
</body>
</html>