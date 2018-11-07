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
	die("請重新輸入");
}
$data = "time.json";
$find = false;
$fileopen = fopen($data,"r");
$jsondecode = json_decode(fread($fileopen,filesize($data)));
for($i = 0;$i<count($jsondecode);$i++){
	if($jsondecode[$i]->give == $acc){
		$find = true;
		echo "轉出帳號:";
		echo $jsondecode[$i]->give;
		echo "<br />";
		echo "轉入帳號:";
		echo $jsondecode[$i]->get;
		echo "<br />";
		echo "金額:";
		echo $jsondecode[$i]->amont;
		echo "<br />";
		echo "成功與否:";
		echo $jsondecode[$i]->true_or_false;
		echo "<br />";
		echo $jsondecode[$i]->time;
		echo "<br />";
		echo "------------------------------------------------";
		echo "------------------------------------------------<br />";
	}else if($jsondecode[$i]->get == $acc){
		$find = true;
		echo "轉出帳號:";
		echo $jsondecode[$i]->give;
		echo "<br />";
		echo "轉入帳號:";
		echo $jsondecode[$i]->get;
		echo "<br />";
		echo "金額:";
		echo $jsondecode[$i]->amont;
		echo "<br />";
		echo "成功與否:";
		echo $jsondecode[$i]->true_or_false;
		echo "<br />";
		echo $jsondecode[$i]->time;
		echo "<br />";
		echo "------------------------------------------------";
		echo "------------------------------------------------<br />";
	}
}
if($find == false){
	echo "無此帳號,或是沒有資料";
}
fclose($fileopen);
?>