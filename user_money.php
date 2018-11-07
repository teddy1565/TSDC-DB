<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php
if($_GET['acc']!=null){
	$acc = $_GET['acc'];
}else{
	die("請與管理員確認!");
}
$data = "database.json";
$fileopen = fopen($data,"r");
$jsondecode = json_decode(fread($fileopen,filesize($data)));
for($i=0;$i<count($jsondecode);$i++){
	if($jsondecode[$i]->uid == $acc){
		echo "您的餘額為:";
		echo $jsondecode[$i]->money;
	}
}
fclose($fileopen);
?>