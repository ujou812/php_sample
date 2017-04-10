<?php
session_start();

$prefectureCD_p = $_POST["prefectureCD"];
$prefectureName_p = $_POST["prefectureName"];
$id = $_POST["id"];
$flg_u = $_SESSION['btnUpdate'];

date_default_timezone_set('Asia/Tokyo');
$ctime=date("Y-m-d H:i:s");

$my_Con = 
mysql_connect("localhost","user","user");
if ($my_Con == false){
die("MYSQLの接続に失敗しました。".mysql_error());
}else{echo "OK";}//elseがない

$db_selected = mysql_select_db('mst_prefecture', $my_Con );
if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}else{echo 'OK2';}

if(isset($_POST["btnAction"])){

if(!preg_match("/^[0-9]+$/", $prefectureCD_p) || $prefectureCD_p ==""){
	$error[0] = "地域コードが不正です";
}
if($prefectureName_p ==""){
	$error[1] = "地域名が不正です";
	}

if(empty($error)){
    $_SESSION['code'] = str_pad($prefectureCD_p,2,0,STR_PAD_LEFT);
	$_SESSION['name'] = mb_convert_kana($prefectureName_p,‘ASKV’);
	$_SESSION['btnAction']= $_POST["btnAction"]; 
	$_SESSION['btnUpdate']= $_POST["flg_u"];
    header('Location: prefecture_confirm.php');
	exit;
  }	
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>地域マスタ登録</title>
<link rel="stylesheet" type="text/css" href="prefecture_style.css">
</head>
<body>
<?php if(isset($_POST["btnUpdate"])){ ?>

<h1>地域マスタ更新</h1>

<form action="prefecture_edit.php" method="POST">
地域コード: <?php echo $id ; ?>
地域名:<input type="text" name="prefectureName" size="20"/><br>
<font color="red";> <?php if(isset($error[1]) && $flg_u == 1){echo $error[1] ;}else{} ?></font><br>
<input type="submit" name="btnAction" value="更新" id="addbutton"/><br>
<input type="hidden" name="flg_u" value="1"/>
<input type="hidden" name="prefectureCD" value="<?php echo $id; ?>"/>
</form>

<form action="prefecture_list.php?page=1" method="POST">
<input type="submit" name="btnBack" value="戻る" />
</form>

<?php }else{ ?>
<h1>地域マスタ登録</h1>

<div id="main">
<h3>地域データ登録</h3>

<form action="prefecture_edit.php" method="POST">
地域コード:<input type="text" name="prefectureCD" size="2" />
地域名:<input type="text" name="prefectureName" size="20"/><br>
<font color="red";> <?php  if($flg_u == 1){ ?>
<font color="red";> <?php  if(isset($error[0])){echo $error[0];} 
if(isset($error[1])){echo $error[1];}
} ?>
</font>
<input type="submit" name="btnAction" value="登録" id="addbutton"/><br>
<input type="hidden" name="flg_u" value="0"/>

</form>

</div>

<form action="prefecture_list.php?page=1" method="POST">
<input type="submit" name="btnBack" value="戻る" />
</form>

<?php } ?>

</body>
</html>