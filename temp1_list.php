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

//データを配列に格納
while ($row = mysql_fetch_assoc($result)) {
	$no[] = $row['no'];
	$title[] = $row['title'];
	$content[] = $row['content'];
	$time[] = $row['time'];
}

$ctime = htmlspecialchars(date("Y-m-d H:i:s"));

	?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>テンプレート1-article/list</title>
<meta name="description" content="describes">
<meta name="keywords" content="keywords"> 
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/openclose.js"></script>
</head>

<body>
<!--小さな端末用（800px以下端末）のロゴとメニュー-->
<div id="sh">
<h1 class="logo"><a href="index.html"><img src="images/sample.png" alt="Sample Web Site"></a></h1>
<nav id="menubar-s">
<ul>
<li><a href="temp1_home.php">Home</a></li>
<li><a href="temp1_about.php">About</a></li>
<li><a href="temp1_works.php">Works</a></li>
<li><a href="temp1_contact.php">Contact</a></li>
</ul>
</nav>
</div>

<div id="container">

<div id="main">

<img src="<?php echo $save_file; ?>">
<form method="post" action="temp1_confirm.php">
  <div class="post">
    <h2>記事投稿</h2>
    <p>題名</p>
    <p><input type="text" name="article[title]" size="40" ></p>
    <p>本文</p>
    <p><textarea name="article[content]" rows="14" cols="120"></textarea></p>
    <input type = "hidden" name ="article[time]" value = <?php echo $ctime; ?> >
    <input type = "hidden" name ="article[filename]" value =<?php echo $save_file; ?> >
    <input type = "text" name ="article[tag]">
    <p><input name="submit" type="submit" value="投稿"></p>
  </div>
</form>

</div>
<!--/main-->

<div id="sub">

<!--PC用（801px以上端末）ロゴ-->
<h1 class="logo"><a href="index.html"><img src="images/logo.png" alt="Sample Web Site"></a></h1>
<!--PC用（801px以上端末）メニュー-->
<nav id="menubar">
<ul>
<li><a href="temp1_home.php">Home</a></li>
<li><a href="temp1_about.php">About</a></li>
<li><a href="temp1_works.php">Works</a></li>
<li><a href="temp1_contact.php">Contact</a></li>
</ul>
</nav>

</div>
<!--/sub-->

<p id="pagetop"><a href="#">↑ PAGE TOP</a></p>

<footer>
<small>Copyright&copy; <a href="index.html">Sample Web Site</a> All Rights Reserved.</small>
</footer>

</div>
<!--/container-->

<!--画面左上の装飾画像-->
<img src="images/bg1.png" id="kazari">

<!--更新情報の開閉処理条件設定　800px以下-->
<script type="text/javascript">
if (OCwindowWidth() <= 800) {
	open_close("newinfo_hdr", "newinfo");
}
</script>

<!--メニューの３本バー-->
<div id="menubar_hdr" class="close"><span></span><span></span><span></span></div>
<!--メニューの開閉処理条件設定　800px以下-->
<script type="text/javascript">
if (OCwindowWidth() <= 800) {
	open_close("menubar_hdr", "menubar-s");
}
</script>
</body>
</html>


</body>
</html>