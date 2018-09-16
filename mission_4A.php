<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<form action = "mission_4.php" method="post">



<?php
//データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//テーブルの作成
$sql="CREATE TABLE mission4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
."password char(32)"
.");";
$stmt = $pdo->query($sql);
?>



<?php
//データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//新規投稿
$name=$_POST['name'];
$comment=$_POST['comment'];
$edit_num = $_POST['edit_num'];
$pass = $_POST['pass'];

//条件分岐
if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['pass']) and empty($_POST['edit_num'])){
	if(preg_match("/^[a-zA-Z0-9]+$/",$pass)){
	$sql = $pdo -> prepare("INSERT INTO mission4 (name, comment, password) VALUES (:name, :comment, :password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':password', $pass, PDO::PARAM_STR);
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$pass = $_POST['pass'];
	$sql -> execute();
	}else{
	echo "パスワードは英数字以外入力できません";
	}
}



//追記処理
if(!empty($_POST['edit_num'])){
$id = $_POST['edit_num'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$pass = $_POST['pass'];
$date = date("Y/m/d H:i:s");
$sql = "update mission4 set name='$name', comment='$comment', password='$pass', date='$date' where id=$id";
$result = $pdo->query($sql);
}


//編集する内容をフォームに表示する処理
if(!empty($_POST['edit']) and !empty($_POST['pass_e'])){
$id = $_POST['edit'];
$pass_e = $_POST['pass_e'];
$sql = 'SELECT * FROM mission4';
$results = $pdo->query($sql);
	foreach ($results as $row){
		if($row['id'] == $id and $row['password'] == $pass_e){
		$edit_id = $row['id'];
		$edit_nm = $row['name'];
		$edit_cm = $row['comment'];
		}
	}
}

?>





<form>
<br>
<b>＜投稿＞</b><br>
　　　　　名前：<input type="text" name="name" value="<?php
							if(!empty($_POST['edit']) and !empty($_POST['pass_e'])){
							echo $edit_nm;
							}
							?>"
							><br>
　　　コメント：<input type="text" name="comment" value="<?php
							if(!empty($_POST['edit']) and !empty($_POST['pass_e'])){
							echo $edit_cm;
							}
							?>"
							><br>
<!-後で隠す->
<input type="hidden" name="edit_num" value="<?php
						if(!empty($_POST['edit']) and !empty($_POST['pass_e'])){
						echo $edit_id;
						}
						?>"
						>
　　パスワード：<input type="text" name="pass">
 <input type="submit" value="送信"><br><br>


<b>＜削除＞</b><br>
　削除対象番号：<input type="number" name="delete"><br>
　　パスワード：<input type="text" name="pass_d">
 <input type="submit" value="削除"><br><br>


<b>＜編集＞</b><br>
　編集対象番号：<input type="number" name="edit" ><br>
　　パスワード：<input type="text" name="pass_e">
 <input type="submit" value="編集"><br><br><br>


<b>＜投稿一覧＞</b><br>
</form>





<?php
//削除処理
//データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);


//ポストで受け取った処理を代入
$pass_d = $_POST['pass_d'];


//条件分岐
if(!empty($_POST['delete']) and !empty($_POST['pass_d'])){
$id = $_POST['delete'];
$sql = "delete from mission4 where id=$id and password=$pass_d";
$result = $pdo->query($sql);
}


//データベース内のデータ表示
$sql = 'SELECT * FROM mission4 ORDER BY id';
$results = $pdo -> query($sql);
foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	}
?>



</body>
</html>

