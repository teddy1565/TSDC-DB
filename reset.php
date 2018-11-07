<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php
if($_GET['acc']!=null&&$_GET['rpassword']!=null){
	$acc = $_GET['acc'];
	$password = $_GET['rpassword'];
}else{
	die("請輸入資訊");
}
$checkacc = false;
$checkpss = false;
$data = "database.json";
$fileopen = fopen($data,"r");
$jsondecode = json_decode(fread($fileopen,filesize($data)));
for($i=0;$i<count($jsondecode);$i++){
	if($jsondecode[$i]->uid == $acc){
		$checkacc = true;
		$o = $i;
	}
	if($jsondecode[$i]->password == $password){
		$checkpss = true;
	}
}
if($checkpss == true){
	die("請輸入跟原始密碼不同的密碼");
}else if($checkacc == false){
	die("帳號不存在,請重新確認輸入");
}else if($checkacc == true && $checkpss == false){
	$jsondecode[$o]->password = $password;
	$jsondecode[$o]->passwordcheck = 0;
	$jsonencode = json_encode($jsondecode);
	fclose($fileopen);
	$fileopenX = fopen($data,"w");
	fwrite($fileopenX,$jsonencode);
	fclose($fileopenX);
	echo"變更成功";
}
?>