<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<link rel="stylesheet" type="text/css" href="mission_6-2.css">
</head>
<body>
<form action = "mission_6-2.php" method="post">

<br>
<p>メールが送信されました。</p>
<p>ユーザーID、パスワード、メールに記載されている認証コードを入力して登録を完了させて下さい。</p>

<!--入力フォーム-->
ユーザーID<br>
<input type="text" name="userid" placeholder="ユーザーIDを入力"><br><br>
パスワード<br>
<input type="password" name="pass" placeholder="パスワードを入力"><br><br>
認証コード<br>
<input type="password" name="code" placeholder="認証コードを入力"><br><br>
<input type="submit" value="送信する"><br>

</form>



<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

//テーブルの作成
	$sql="CREATE TABLE R2"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."mail2 TEXT,"
	."name2 char(32),"
	."userid2 TEXT,"
	."pass2 TEXT"
	.");";
	$stmt = $pdo->query($sql);



//認証
	if(!empty($_POST['userid']) and !empty($_POST['pass']) and !empty($_POST['code'])){
	$sql = 'SELECT * FROM R1';
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($row['userid'] == $_POST['userid'] and $row['pass'] == $_POST['pass'] and $row['code'] == $_POST['code']){
				if(strtotime($row['limi']) >= strtotime(date("Y/m/d H:i:s"))){
				$sql = $pdo -> prepare("INSERT INTO R2 (mail2, name2, userid2, pass2) VALUES (:mail2, :name2, :userid2, :pass2)");
				$sql -> bindParam(':mail2', $mail, PDO::PARAM_STR);
				$sql -> bindParam(':name2', $name, PDO::PARAM_STR);
				$sql -> bindParam(':userid2', $userid, PDO::PARAM_STR);
				$sql -> bindParam(':pass2', $pass, PDO::PARAM_STR);
				$mail = $row['mail'];
				$name = $row['name'];
				$userid = $row['userid'];
				$pass = $row['pass'];
				$sql -> execute();
				header("location: mission_6-2send.php");
				}else{
				echo '認証期限切れです。最初からやり直してください。';
				}
			}
		}
	}
?>



</body>
</html>

