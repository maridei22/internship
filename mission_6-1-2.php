<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<link rel="stylesheet" type="text/css" href="mission_6-1.css">
</head>
<body>
<form action = "mission_6-1.php" method="post">


<br>
<h2>新規登録画面</h2>
<p>全項目記入してから送信ボタンを押してください。</p>
<p>名前とユーザーIDとパスワードは英数字のみ使用可能です。</p>

<!--入力フォーム-->
メールアドレス<br>
<input type="text" name="mail" placeholder="メールアドレスを入力"><br><br>
名前<br>
<input type="text" name="name" placeholder="名前を入力"><br><br>
ユーザーID<br>
<input type="text" name="userid" placeholder="任意のユーザーIDを入力"><br><br>
パスワード<br>
<input type="password" name="pass" placeholder="任意のパスワードを入力"><br><br>
<input type="submit" value="送信する"><br><br><br>

<a href="mission_6-login.php">ログインはこちら</a>



<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

//条件分岐
	if(!empty($_POST['mail']) and !empty($_POST['name']) and !empty($_POST['userid']) and !empty($_POST['pass'])){
	$sql = 'SELECT * FROM R1';
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($row['mail'] == $_POST['mail']){
			echo "このメールアドレスは既に仮登録されています。メールに記載されているURLから認証を済ませてください。";
			$_POST['mail'] ="";
			$_POST['name'] ="";
			$_POST['userid'] ="";
			$_POST['pass'] ="";
			}
		}
	}

	if(!empty($_POST['mail']) and !empty($_POST['name']) and !empty($_POST['userid']) and !empty($_POST['pass'])){
	$sql = 'SELECT * FROM R2';
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($row['mail2'] == $_POST['mail'] or $row['userid2'] == $_POST['userid']){
			echo "このメールアドレスまたはユーザーIDは既に登録されています。";
			$_POST['mail'] ="";
			$_POST['name'] ="";
			$_POST['userid'] ="";
			$_POST['pass'] ="";
			}
		}
	}
?>

</form>



<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

//テーブルの作成
	$sql="CREATE TABLE R1"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	. "limi timestamp,"
	. "code TEXT,"
	. "mail TEXT,"
	. "name char(32),"
	. "userid TEXT,"
	. "pass TEXT"
	.");";
	$stmt = $pdo->query($sql);
?>



<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

//条件分岐
	if(!empty($_POST['mail']) and !empty($_POST['name']) and !empty($_POST['userid']) and !empty($_POST['pass'])){
		if(ctype_alnum($_POST['name']) and $_POST['userid'] and $_POST['pass']){
		$sql = $pdo -> prepare("INSERT INTO R1 (code, mail, limi, name, userid, pass) VALUES (:code, :mail, :limi, :name, :userid, :pass)");

	//データ入力処理
		$sql -> bindParam(':code', $code, PDO::PARAM_STR);
		$sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
		$sql -> bindParam(':limi', $limi, PDO::PARAM_STR);
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':userid', $userid, PDO::PARAM_STR);
		$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

	//ランダム文字列生成 (英数字)
	//$length: 生成する文字数
		$str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ';
		$str_r = substr(str_shuffle($str), 0, 5);
		$code = $str_r;

	//ポストで受け取った処理を代入
		$mail = $_POST['mail'];
		$limi = date('Y/m/d H:i', strtotime('+60 minute'));
		$name = $_POST['name'];
		$userid = $_POST['userid'];
		$pass = $_POST['pass'];

		$sql -> execute();

	//メール作成送信用の画面
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$subject = '登録確認メール';
		$message =
		"\n"
		."====================================\n"
		."■送信日付: ".date('Y-m-d H:i:s')."\n"
		."■送信内容: 新規登録を受け付けました。\n"
		."            登録はまだ完了していません。下記のURLより登録を完了させてください。\n"
		."            http://tt-268.99sv-coco.com/mission_6-2.php \n"
		."            $limi までに登録を行ってください。 \n"
		."            認証コードは $code です。\n"
		."====================================\n"; 
		$headers = "From: root@x74.cocospace.com";

	//条件分岐
		if(mb_send_mail($mail, $subject, $message, $headers,'-f root@x74.cocospace.com')){
		header("location: mission_6-2.php");;
		}else{
		echo "メールの送信に失敗しました<br>";
		}
		}else{
		echo'英数字以外入力できません';
		}
		}
?>

</body>
</html>
