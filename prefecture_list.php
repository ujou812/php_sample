<?php
if(isset($_POST['page'])){
     $page=$_POST['page'];
    }else{
	$page="1";
}
$keyword_name= $_POST["prefecture_Name"];
$keyword_cd = $_POST["prefecture_CD"];

$my_Con = 
mysql_connect("localhost","user","user");
if ($my_Con == false){
die("MYSQLの接続に失敗しました。".mysql_error());
}
$db_selected = mysql_select_db('mst_prefecture', $my_Con );
if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}
$recordSet = mysql_query("SELECT COUNT(prefecture_cd) as cnt FROM test1 WHERE delete_flg = 0 ");//,$my_Con不要
$ares = (mysql_fetch_assoc($recordSet)); 

session_start();

$keyword_name= 0;
$keyword_cd = 0;

//検索ボタンが押された場合、セッションに格納
if(isset($_POST["submit"])){

$keyword_cd=str_pad($_POST["prefecture_CD"],2,0,STR_PAD_LEFT);
$keyword_name=mb_convert_kana($_POST["prefecture_Name"],‘ASKV’);
}

//検索を実施
$cnt_s = 0;

if(isset($_POST["submit"])){
	if($keyword_cd!=""){
		echo "SELECT * FROM test1 WHERE prefecture_cd = '".$keyword_cd."' ORDER BY insert_date DESC";
	$search = mysql_query("SELECT * FROM test1 WHERE prefecture_cd = '$keyword_cd' ORDER BY insert_date DESC");
	}
	if($keyword_name!=""){ 
	$search = mysql_query("SELECT * FROM test1 WHERE prefecture_name LIKE '%".$keyword_name."%' ORDER BY insert_date DESC ");}
	
	//ヒットした内容を配列に格納
    while($row_s = mysql_fetch_assoc($search)) {
	$prefecture_cd_s[] = $row_s['prefecture_cd'];
	$prefecture_name_s[] = $row_s['prefecture_name'];
	$update_date_s[] = $row_s['update_date'];
    }
	$cnt_s = count($prefecture_cd_s);

	
if(empty($search)){echo "検索クエリに失敗しました";}
}

if(isset($_POST["submit"])){
	$cnt[0]=$cnt_s;
	}

$cnt[] = $ares['cnt'];
echo $cnt[0]."page";

$maxPage= ceil($cnt[0]/10);

echo $maxPage;
$start = ($page - 1) * 10;

echo $maxPage;

//表示
$result = mysql_query("SELECT * FROM test1 WHERE delete_flg = 0 ORDER BY update_date DESC LIMIT 10 OFFSET ".$start);
if (!$result) {
    die('SELECTクエリーが失敗しました。'.mysql_error());
}


//データを配列に格納
while ($row = mysql_fetch_assoc($result)) {
	$prefecture_cd[] = $row['prefecture_cd'];
	$prefecture_name[] = $row['prefecture_name'];
	$insert_date[] = $row['insert_date'];
	$update_date[] = $row['update_date'];
}
$cnt = count($prefecture_cd);


//ページング
function paging($maxPage,$page,$keyword_cd,$keyword_name){
	$page = max($page, 1);
	$next = $page+1;
	$prev = $page-1;

if($page > 1 ) {
	if(isset($_POST["submit"])){ ?>

    <div id="button0">
	<form action="prefecture_list.php?page=<?php echo $prev ; ?>" method="POST" >
    <input type="submit" name="submit" value="前へ"/>
	<input type="hidden" name="prefecture_CD" value="<?php echo $keyword_cd ; ?>"/>
    <input type="hidden" name="prefecture_Name" value="<?php echo $keyword_name ; ?>"/>
    <input type="hidden" name="page" value="<?php echo $prev; ?>"/>
    </form>
	<?php }else{ ?>
    <form action="prefecture_list.php?page= <?php echo $prev ; ?>" method="POST" >
    <input type="submit" name="btnBeforePage" value="前へ"/>
	<input type="hidden" name="page" value="<?php echo $prev; ?>"/>
    </form>
    </div>
	<?php }
}
if ($page < $maxPage ){
	if(isset($_POST["submit"])){ ?>
    <div id="button1">
   <form action="prefecture_list.php?page= <?php echo $next; ?>" method="POST" >
   <input type="submit" name="submit" value="次へ"/>
   <input type="hidden" name="prefecture_CD" value="<?php echo $keyword_cd; ?>"/>
   <input type="hidden" name="prefecture_Name" value="<?php echo $keyword_name; ?>"/>
   <input type="hidden" name="page" value="<?php echo $next; ?>"/>
   </form>
   <?php }else{ ?>
	<form action="prefecture_list.php?page=<?php echo $next; ?>" method="POST" >
    <input type="hidden" name="page" value="<?php echo $next; ?>"/>
    <input type="submit" name="btnAfterPage" value="次へ"/>
	</form>
    </div>
	<?php 
	}
}
}

?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>地域マスタ一覧</title>
<link rel="stylesheet" type="text/css" href="prefecture_style.css">
</head>

<body>
<h1>地域マスタ一覧</h1>
<div id="search">
<form action="prefecture_list.php?page=1" method="POST" >
地域コード：<input type="label" name="prefecture_CD" size="2"/>
地域名：<input type="text" name="prefecture_Name"  size="20"/>
<input type="hidden" name="submit" value="submit"/>
<input type="submit" name="btnSearch" value="search" />
</form>
</div>

<div id="body" >
<?php 

if(isset($_POST["btnSearch"]) && $_POST['prefecture_CD']=="" && $_POST['prefecture_Name']==""){ ?>
		<font color="red">検索条件が不正です</font><br>
        <form action="prefecture_list.php" method="POST">
        <input type="submit" name="btnBack" value="戻る" />
        </form>
<?php }

elseif(isset($_POST["btnSearch"]) && isset($_POST["prefecture_CD"])||isset($_POST["prefecture_Name"])){ ?>
<p>全<?php echo $cnt_s; ?>件中　<?php if($cnt_s != 0 ){echo ($page-1)*10+1 ;}else{echo "0";} ?> ~ <?php echo min($page*10,$cnt_s) ; ?>  件表示</p>

<?php
if($cnt_s == 0){
	echo "データが存在しません";
	}else{
?>

<table width="600" border="1">
  <tbody>
  <tr>
  <td>登録コード</td>
  <td>登録名</td>
  <td>更新日時</td>
  <td></td>
  <td></td>
  </tr>

<?php 
for($i=($page-1)*10; $i<$page*10; $i++){
	if($i<$cnt_s){
?>
    <tr>
      <td><?php echo $prefecture_cd_s[$i]; ?></td>
      <td><?php echo $prefecture_name_s[$i]; ?></td>
      <td><?php echo $update_date_s[$i]; ?></td>
      <td>
          <form action="prefecture_confirm.php" method="POST">
          <input type="submit" name="btnDelete" value="削除" />
          <input type="hidden" name="id" value="<?php echo $prefecture_cd_s[$i]; ?>" >  
           <input type="hidden" name="name" value="<?php echo $prefecture_name_s[$i]; ?>" > 
          </form>
      </td>
      <td>
          <form action="prefecture_complete.php" method="POST">
          <input type="submit" name="btnUpdate" value="更新" />
          <input type="hidden" name="id" value="<?php echo $prefecture_cd_s[$i]; ?>" >  
          </form>
      </td>
    </tr>

<?php 
	}
}
}?>

  </tbody>
</table>

</div>

<form action="prefecture_list.php" method="POST">
<input type="submit" name="btnBack" value="戻る" />
</form>
<form action="prefecture_edit.php" method="POST">
<input type="submit" name="btnBack" value="追加" id="addbutton"/>
</form>

<?php 
paging($maxPage,$page,$keyword_cd,$keyword_name);
}
?>

<?php if(!isset($_POST["submit"])){?>
<table width="600" border="1">
  <tbody>
  <tr>
  <td>登録コード</td>
  <td>登録名</td>
  <td>更新日時</td>
  <td></td>
  <td></td>
  </tr>

<?php
for($i=0; $i<$cnt; $i++){
?>
    <tr>
      <td><?php echo $prefecture_cd[$i]; ?></td>
      <td><?php echo $prefecture_name[$i]; ?></td>
      <td><?php echo $update_date[$i];  ?></td>
      <td>
          <form action="prefecture_confirm.php" method="POST">
          <input type="submit" name="btnDelete" value="削除" />
          <input type="hidden" name="id" value="<?php echo $prefecture_cd[$i]; ?>" >  
          <input type="hidden" name="name" value="<?php echo $prefecture_name[$i]; ?>" > 
          </form>
      </td>
      <td>
          <form action="prefecture_edit.php" method="POST">
          <input type="submit" name="btnUpdate" value="更新" />
          <input type="hidden" name="id" value="<?php echo $prefecture_cd[$i]; ?>" >  
          </form>
      </td>
    </tr>  
<?php 
}
?>
 </tbody>
</table>

<form action="prefecture_edit.php" method="POST">
<input type="submit" name="btnBack" value="追加" id="addbutton"/>
</form>

<?php
paging($maxPage,$page,$keyword_cd,$keyword_name);

}
?>

</body>
</html>