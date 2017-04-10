
<?php
session_start();

date_default_timezone_set('Asia/Tokyo');
$ctime = htmlspecialchars(date("Y-m-d H:i:s"));
$code  = htmlspecialchars($_SESSION['code']);
$name  = htmlspecialchars(mb_convert_kana($_SESSION['name'],'ASKV'));
$ctime_delete = htmlspecialchars(date("Y-m-d H:i:s"));
$_POST["btnUpdate"] = $_SESSION['btnUpdate'] ;
$_POST["btnAction"] = $_SESSION['btnAction'] ;
$id = $_POST["id"];
$name_flg = $_POST["name"];
$flg = 0;

$my_Con = 
mysql_connect("localhost","user","user");
if ($my_Con == false){
die("MYSQLの接続に失敗しました。");//mysql_error()不要
}

$db_selected = mysql_select_db('mst_prefecture', $my_Con );
if (!$db_selected){
    die('データベース選択失敗です。');//mysql_error()不要
}else{echo '';}

$result=mysql_query('SELECT * FROM test1');
if (!$result) {
    die('SELECTクエリーが失敗しました。');//mysql_error()不要
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>地域マスタ登録確認</title>
<link rel="stylesheet" type="text/css" href="prefecture_style.css">
</head>

<body>
<?php
if(isset($_POST["btnDelete"])){ 
    $flg = 1;?>
	<h1>地域データ削除確認</h1>

<div id="main">
    <?php
	$result_flg = mysql_query("UPDATE test1  SET delete_flg = 1 , delete_date = '$ctime_delete' WHERE prefecture_cd = '$id'");
if (!$result_flg) {
  exit('データを削除できませんでした。');//mysql_error()不要
}?>

<p>削除コード：<?php echo $id ?></p>
<p>削除名：<?php echo $name_flg ?></p>	
 
<form action="prefecture_list.php?page=1" method="POST">
<input type="submit" name="btnDelete" value="削除" id="addbutton"/>
</form><br>

</div>

<form action="prefecture_list.php?page=1" method="POST">
<input type="submit" name="btnBack" value="戻る" />
</form>

<?php } 

elseif($_POST["btnUpdate"]=="0"){
?>

<div id="main">
<h1>地域データ登録確認</h1>
<?php 
     $result = mysql_query("INSERT INTO test1(prefecture_cd, prefecture_name,insert_date, delete_flg, update_date) VALUES('$code','$name','$ctime',0,'$ctime')");
	 if(!$result){
     exit('データを更新できませんでした');
		     }
		} 
if($_POST["btnUpdate"]=="1"){
    $result = mysql_query("UPDATE test1  SET prefecture_name = '$name' , update_date = '$ctime'  WHERE prefecture_cd = '$code'");
	if(!$result){
		exit('データを更できませんでした');
		}
}
if($flg != 1){ 
?>

<p>登録コード：<?php echo $code ;?></p>
<p>登録名：<?php echo $name ;?></p>
	
<form action="prefecture_complete.php" method="POST">
<input type="submit" name="btnBack" value="登録" id="addbutton"/>
<input type="hidden" name="code" value="<?php echo $code ; ?>" />  
<input type="hidden" name="name" value="<?php echo $name ; ?>" /> 
</form><br>
</div>

<form action="prefecture_edit.php" method="POST">
<input type="submit" name="btnBack" value="戻る" />
</form>

<?php } ?>

</body>
</html>