<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php
include 'Csheet.php';
if($_GET["acc"]!=null&&$_GET['password']!=null){
	$acc = $_GET["acc"];
	$password = $_GET['password'];
}else{
	die("請輸入要新增的帳號密碼");
}
if($acc == "admin"){
	die("帳號重複");
}
$array = array("uid"=>$acc,"password"=>$password,"passwordcheck"=>0,"money"=>0);
$data="database.json";
$check = save_to_database($data,$array,2,"uid");
if($check == true){
	echo "新增成功!";
}else{
	echo "新增失敗!";
}

?>