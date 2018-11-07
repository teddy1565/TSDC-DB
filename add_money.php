<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php
if($_GET['acc']!=null&&$_GET['money']!=null){
	$acc = $_GET['acc'];
	$money = $_GET['money'];
}else{
	die("請輸入帳號及金額");
}
$checkacc = false;
$data = "database.json";
$fileopen = fopen($data,"r");
$jsondecode = json_decode(fread($fileopen,filesize($data)));
for($i=0;$i<count($jsondecode);$i++){
	if($jsondecode[$i]->uid == $acc){
		$checkacc = true;
		$o = $i;
	}
	
}
if($checkacc == false){
	fclose($fileopen);
	die("查無帳號");
}else{
	$jsondecode[$o]->money += $money;
	$jsonencode = json_encode($jsondecode);
	fclose($fileopen);
	$fileopenX = fopen($data,"w");
	fwrite($fileopenX,$jsonencode);
	fclose($fileopenX);
	echo "新增成功!";
}
?>