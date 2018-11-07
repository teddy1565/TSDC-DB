<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php
if($_GET['acc']!=null&&$_GET['hisacc']!=null&&$_GET['money']!=null){$acc =$_GET['acc'];$hisacc = $_GET['hisacc'];$money = $_GET['money'];}else{die("請輸入資訊");}
givemoney($acc,$hisacc,$money);
function givemoney($acc,$hisacc,$money){
	$data = "database.json";
	$findacc = false;
	$fileopen = fopen($data,"r");
	$jsondecode = json_decode(fread($fileopen,filesize($data)));
	
	for($i=0;$i<count($jsondecode);$i++){
		if($jsondecode[$i]->uid == $acc){
			$o = $i;
		}
		if($jsondecode[$i]->uid == $hisacc){
			$k = $i;
			$findacc = true;
		}
		
	}
	if($findacc == true){
			$mymoney = $jsondecode[$o]->money;
			$ans = $mymoney-$money;
			if($ans<0){
				record_time($acc,$hisacc,$money,"false");
				die("帳號金額不足,轉帳失敗");fclose($fileopen);
			}else{
				$jsondecode[$k]->money += $money;
				$jsondecode[$o]->money -= $money;
				$jsonencode = json_encode($jsondecode);
				fclose($fileopen);
				$fileopenX = fopen($data,"w");
				fwrite($fileopenX,$jsonencode);
				fclose($fileopenX);
				record_time($acc,$hisacc,$money,"true");
				echo"轉帳成功";
			}
			
		}else{
			record_time($acc,$hisacc,$money,"false");
			fclose($fileopen);
			die("查無對方帳號,轉帳失敗");
		}
}
function record_time($acc,$hisacc,$money,$about){
	$data = "time.json";
	date_default_timezone_set('Asia/Taipei');
	$thedate = date("Y-m-d-H-i-s");
	$array = array("give"=>$acc,"get"=>$hisacc,"amont"=>$money,"true_or_false"=>$about,"time"=>$thedate);
	$fileopen = fopen($data,"r");
	$jsondecode = json_decode(fread($fileopen,filesize($data)));
	$jsondecode[] = $array;
	$jsonencode = json_encode($jsondecode);
	fclose($fileopen);
	$fileopenX = fopen($data,"w");
	fwrite($fileopenX,$jsonencode);
	fclose($fileopenX);
}
?>