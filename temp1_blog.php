<?php
$my_Con = 
mysql_connect("localhost","user","user");

if ($my_Con == false){
die("MYSQLの接続に失敗しました。".mysql_error());

}else{
	echo "";
	}

$db_selected = mysql_select_db('blog', $my_Con );

if (!$db_selected){
    die('データベース選択失敗です。'.mysql_error());
}else{
	echo '';
	}
	//表示


//foreach($_POST as $idx => $val){echo "$idx = $val<br>";}

if(!$_POST['search']){
$result = mysql_query("SELECT * FROM post ORDER BY time DESC");
if (!$result) {
    die('SELECTクエリーが失敗しました。'.mysql_error());
}

//データを配列に格納
while ($row = mysql_fetch_assoc($result)) {
	$no[] = $row['no'];
	$title[] = $row['title'];
	$content[] = $row['content'];
	$time[] = $row['time'];
}
}

if(isset($_POST['search'])){
	$keyword = $_POST['keyword'];
	$search = mysql_query("SELECT *  FROM post WHERE title LIKE '%".$keyword."%' ORDER BY time DESC");
	
while ($row = mysql_fetch_assoc($search)) {
	$no[] = $row['no'];
	$title[] = $row['title'];
	$content[] = $row['content'];
	$time[] = $row['time'];
	$filename[] = $row['filename'];
}

if($no == 0){
	echo "検索はヒットしません";
}
}

$num = 10;
if(count($no) <= $num ){
	$num = count($no);
	}else{
		break;}
		
//ファイルのパス
$filepath = 'pictures/test.pdf';

//リネーム後のファイル名
$filename = 'download.pdf';

//ファイルタイプを指定
header('Content-Type: application/jpg');

/*//ファイルサイズを取得し、ダウンロードの進捗を表示
header('Content-Length: '.filesize($filepath));

//ファイルのダウンロード、リネームを指示
header('Content-Disposition: attachment; filename ="'.$filename.'"');

//ファイルを読み込みダウンロードを実行
if(isset($_POST['download'])){
//readfile($filepath);
}*/
	?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>テンプレート1-blog</title>
<meta name="description" content="describes">
<meta name="keywords" content="keywords"> 
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/openclose.js"></script>
</head>

<body>
<?php include_once('temp1_header.php'); ?>

<div id="container">

<div id="main">

<form action="temp1_blog.php" method="POST">
<input type="text" name="keyword"/>
<input type="submit" name="search" value="検索" />
</form>


<section>
<p> サイトの説明をします。</p>

</section>

<table width="600" border="1">
  <tbody>
  <tr>
  <td>登録コード</td>
  <td>登録名</td>
  <td>内容</td>
  <td>更新日時</td>
  <td></td>
  <td></td>
  </tr>

<?php
for($i=0; $i<$num; $i++){
?>
    <tr>
      <td><form action="file:///Macintosh HD/Applications/XAMPP/xamppfiles/htdocs/temp1_article.php" method="POST">
      <?php echo $no[$i]; ?>
      <input type="hidden" name="id" value="<?php echo $no[$i]; ?>" >  
      </form>
      </td>
      <td>
      <form action="file:///Macintosh HD/Applications/XAMPP/xamppfiles/htdocs/temp1_article.php" method="POST">
      <?php echo $title[$i]; ?>
      <input type="hidden" name="id" value="<?php echo $no[$i]; ?>" >  
      </form>
      </td>
      <td><?php echo $content[$i];  ?></td>
      <td><?php echo $time[$i];  ?></td>
      <td>
          <form action="temp1_article.php" method="POST">
          <input type="submit" name="btnDelete" value="記事を見る" />
          <input type="hidden" name="no" value="<?php echo $no[$i]; ?>" >  
          </form>
      </td>
    </tr>  
<?php 
}
?>
 </tbody>
</table>

</div>
<!--/main-->

</div>
<!--/container-->
<?php include_once('temp1_footer.php'); ?>
</body>
</html>


</body>
</html>