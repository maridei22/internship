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

<h2>���O�C�����</h2>

<!--���̓t�H�[��-->
���[�U�[ID<br>
<input type = "text" name ="userid2" placeholder ="���[�U�[ID�����"><br><br>
�p�X���[�h<br>
<input type = "password" name = "pass2" placeholder ="�p�X���[�h�����"><br><br>
<input type = "submit" value ="���O�C��"><br><br>

</form>



<?php
//�f�[�^�x�[�X�ւ̐ڑ�
	$dsn = 'mysql:dbname=�f�[�^�x�[�X��;host=localhost';
	$user = '���[�U�[��';
	$password = '�p�X���[�h';
	$pdo = new PDO($dsn,$user,$password);

//�F��
	if(!empty($_POST['userid2']) and !empty($_POST['pass2'])){
	$sql = 'SELECT * FROM R2';
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($row['userid2'] ==$_POST['userid2'] and $row['pass2'] ==$_POST['pass2']){
					
			$_SESSION[�euserid�f] = $row['userid2'];
			$_SESSION[�eusername�f] = $row['name2'];

			header("location: mission_6-talk.php");
			}
		}
	echo "���O�C���ł��܂���ł���";
	}
?>



<br>
<a href="mission_6-1.php">�V�K�o�^�͂�����</a>

</body>
</html>

