<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>テンプレート1-footer</title>
</head>

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

<body>
</body>
</html>