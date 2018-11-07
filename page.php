<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php
if($_GET['user']!=null){$user = $_GET['user'];}
if($user = "admin"){
	echo "<form action='database.php' method='GET'>
			<input type = 'text' name = 'acc' placeholder='帳號'>
			<input type = 'password' name = 'password' placeholder='密碼'><br />
			<input type = 'submit' value='登入'>
		  </form>";
}else if($user = "user"){
	echo "<form action='datebase.php' method='GET'>
			<input type = 'text' name = 'acc' placeholder='帳號'>
			<input type = 'password' name = 'password' placeholder='密碼'><br />
			<input type = 'submit' value='登入'>
		  </form>";
}
?>
