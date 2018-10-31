<?php
//ログイン画面表示
	session_start();
	if(!isset($_SESSION[‘userid’]) or !isset($_SESSION[‘username’] )){
	header("Location: mission_6-login.php");
	exit;
	}
?>



<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<link rel="stylesheet" type="text/css" href="mission_6-talk.css">
</head>
<body>
<form action = "mission_6-talk.php" method = "post">


<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

//テーブル作成
	$sql= "CREATE TABLE talk"
	." ("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."userid text," 
	."name char(32),"
	."message TEXT,"
	."date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
	."pass TEXT"
	.");";
	$stmt = $pdo->query($sql);

//新規投稿
	if(!empty($_POST['message']) and !empty($_POST['submit'])){
	$sql = $pdo -> prepare("INSERT INTO talk (name, message,userid,pass) VALUES (:name,:message,:userid,:pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':message', $message, PDO::PARAM_STR);
	$sql -> bindParam(':userid', $userid, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$name = $_SESSION[‘username’];
	$message = $_POST['message'];
	$userid = $_SESSION[‘userid’];
	$pass = $_SESSION[‘pass’];
	$sql -> execute();
	}
?>



<!--ヘッダー-->
<div class="header">
<div class="header-logo">フラワーアレンジメント部　掲示板</div>
</div>


<!--メイン-->
<div class="main">
<br>

<?php
	echo "ようこそ $_SESSION[‘username’] さん";
?>
<br>

<!--画像-->
<img src="_20181012_185625.jpg">



<?php
//データベースへの接続
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);



//削除処理
	if(!empty($_POST['delete']) and !empty($_POST['pass_d'])){
	$sql = 'SELECT * FROM talk ORDER BY id';
	$results = $pdo -> query($sql);

//ポストで受け取った処理を代入
	$id = $_POST['delete'];
	$pass_d = $_SESSION['pass'];

	foreach ($results as $row){
		if($row['id'] == $id and $row['pass'] == $pass_d){
		$gg = $row['id'];
		$sql = "delete from talk where id=$gg";
		$result = $pdo->query($sql);
		}
	}
}
?>



<div class="main-list">
<br><br>

<?php
//投稿表示
	$sql = 'select * from talk ORDER BY id';
	$results = $pdo -> query($sql);
		foreach ($results as $row){
		echo $row['id'].', ';
		echo "<p1>".$row['name']."</p1>".', ';
		echo $row['date'].',　';
		echo ID：.$row['userid'].'<br>';
		echo nl2br($row['message']).'<br><br>';
		}
?>
</div>



<!--入力フォーム-->
<div class="main-form">
<br><br>

<b>メッセージの投稿</b><br>
<textarea name="message" rows="8" cols="40" placeholder="メッセージを入力"></textarea><br>
<input type = "submit" name = "submit" value ="投稿する"><br><br><br>

<b>メッセージの削除</b><br>
<input type ="number" name="delete" placeholder="削除対象番号を入力"><br>
<input type="text" name="pass_d" placeholder="パスワードを入力"><br>
<input type="submit" value="削除する"><br>



<br><br><br><br><br><br>
<!--ログアウト-->
<p><input type = "submit" name ="lout" value ="ログアウト"></p>
<br>

<?php
	if ( isset( $_POST[ 'lout' ] ) ){
	unset($_SESSION[‘username’] );
	unset($_SESSION[‘userid’] );
	header("Location: mission_6-logout.php");
	}
?>
</div>
</div>



</body>
</form>
</html>

