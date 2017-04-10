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
$result = mysql_query("SELECT * FROM post ORDER BY time ");
if (!$result) {
    die('SELECTクエリーが失敗しました。'.mysql_error());
}

foreach($_POST as $idx => $val){echo "$idx = $val<br>";}

if(isset($_POST['write'])){
$content_w = $_POST['content'];
$cno_w = $_POST['post_no'];
$time_w = $_POST['time_c'];
$name_w = $_POST['name'];

$write = mysql_query("INSERT INTO comment(post_no, name, content , time ) VALUES('$cno_w','$name_w','$content_w','$time_w')");
	 if(!$write){
     exit('データを更新できませんでした');
		     }
}

$nou = $_POST['no'];
if(isset($_POST['watch'])){$nou = $_POST['no'];}

$article = mysql_query("SELECT * FROM post WHERE no = '$nou' ");

//データを配列に格納
while ($row = mysql_fetch_assoc($article)) {
	$no[] = $row['no'];
	$title[] = $row['title'];
	$content[] = $row['content'];
	$time[] = $row['time'];
	$filename[] = $row['filename'];
}

date_default_timezone_set('Asia/Tokyo');
$ctime = htmlspecialchars(date("Y-m-d H:i:s"));

echo $nou;
$comment = mysql_query("SELECT * FROM comment WHERE post_no = '$nou' ");
//データを配列に格納
while($row_c = mysql_fetch_assoc($comment)){
	$no_c[] = $row_c['no'];
	$name_c[] = $row_c['name'];
	$content_c[] = $row_c['content'];
	$time_c[] = $row_c['time'];
}
echo $no_c[0];
echo $name_c[0];

	?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>テンプレート1-article</title>
<meta name="description" content="describes">
<meta name="keywords" content="keywords"> 
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/openclose.js"></script>
</head>

<body>
<?php include_once('temp1_header.php'); ?>
<div id="container">

<div id="main">

<section>

<img src="<?php echo $filename[0]; ?>" > 

<?php echo $no[0] ; ?>
<br><br>
<span style="text-decoration:overline"> <?php echo $title[0]; ?></span>
<br>

<?php echo $content[0]; ?>

</section>

<section id="comment_write">
<hr>
<form method="post" action="temp1_article.php">
お名前: <input name="name" type="text"><br>
<textarea name="content" cols="60" rows="5" type="text"></textarea><br>
<input type="hidden" value="<? echo $ctime; ?>" name="time_c">
<input type="hidden" value="<? echo $nou; ?>" name="post_no">
<input type="hidden" value="<? echo $nou; ?>" name="no">
<input type="submit" name="write" value="送信">
</form>
</section>

<section id = "comment">
<hr>
<table width="600" border="1">
  <tbody>

<?php
for($i=0; $i<6; $i++){
?>
    <tr>
      <td><?php echo $no_c[$i]; ?></td>
      <td>投稿者：</td>
      <td><?php echo $name_c[$i]; ?></td>
      <td><?php echo $time_c[$i];  ?></td>
    </tr>
    <tr>
    <td><?php echo $content_c[$i]; ?></td>
    </tr>   
<?php 
}
?>
 </tbody>
</table>

<?php for($i=0; $i++; $i<10){ ?>
  <strong><?php echo $no_c[$i]; ?></strong>
  <br><p>投稿者：<?php echo $name_c[$i]; echo $time_c[$i]; ?></p>
  <p><?php echo $content_c[$i]; ?></p>

<?php } ?>
</section>

</div>
<!--/main-->

<?php include_once('temp1_footer.php'); ?>
</div>
<!--/container-->

</body>
</html>


</body>
</html>