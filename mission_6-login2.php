<?php
	session_start();
?>


<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<link rel="stylesheet" type="text/css" href="mission_6-login.css">
</head>
<body>
<form action = "mission_6-login.php" method = "post">

<h2>ログイン画面</h2>

<!--入力フォーム-->
ユーザーID<br>
<input type = "text" name ="userid2" placeholder ="ユーザーIDを入力"><br><br>
パスワード<br>
<input type = "password" name = "pass2" placeholder ="パスワードを入力"><br><br>
<input type = "submit" value ="ログイン"><br><br>

</form>



<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

//認証
	if(!empty($_POST['userid2']) and !empty($_POST['pass2'])){
	$sql = 'SELECT * FROM R2';
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($row['userid2'] ==$_POST['userid2'] and $row['pass2'] ==$_POST['pass2']){
					
			$_SESSION[‘userid’] = $row['userid2'];
			$_SESSION[‘username’] = $row['name2'];

			header("location: mission_6-talk.php");
			}
		}
	echo "ログインできませんでした";
	}
?>



<br>
<a href="mission_6-1.php">新規登録はこちら</a>

</body>
</html>

