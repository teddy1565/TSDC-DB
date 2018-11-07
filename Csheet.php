<?php 
function save_to_database($data,$add_some_thing,$check,$string_obj){ //新增資料庫檔案若成功則回傳true
	/*
	$data= "XXX.json"
	$add_some_thing = Something you want to join(array)
	$check = 1  ----->open Check for duplicate data(PS{mode:1 can't use})
					
					
		   = 2  ------>check jsondecode[$i]->$string_obj
					|-Necessary option -----> $string_obj
					$add_some_thing[$string_obj]
					
		   = 0  ----->close Check for duplicate data
	*/
	$fileopen = fopen($data,"r");
	$jsondecode = json_decode(fread($fileopen,filesize($data)));
	for($i = 0;$i<count($jsondecode);$i++){
		if($check == 1){
			$string_obj = 0;
			if($jsondecode[$i] == $add_some_thing){
				die("Duplicate data!!");
			}
		}else if($check == 2){
			if($jsondecode[$i]->$string_obj == $add_some_thing[$string_obj]){
				die("Duplicate data!!");
			}
		}else if($check == 0){
			$string_obj = 0;
		}
	}
	$jsondecode[] = $add_some_thing;
	$jsonencode = json_encode($jsondecode);
	fclose($fileopen);
	$fileopenX = fopen($data,"w");
	fwrite($fileopenX,$jsonencode);
	fclose($fileopenX);
	return true;
}
function Regular_Expression($string){ //正規表示式,回傳陣列
	$check_contain_number = preg_match("/[0-9]+/",$string); //檢查是否包含數字
	$check_contain_letter = preg_match("/[A-Za-z]+/",$string);//檢查是否包含英文字母
	$check_CAPS = preg_match("/[A-Z]+/",$string);//檢查是否包含大寫字母
	$check_lower = preg_match("/[a-z]+/",$string);//檢查是否包含小寫字母
	$check_contain_spec = preg_match("/[^A-Za-z0-9]/",$string);//檢查是否包含特殊字元
	$check_head_number = preg_match("/^[0-9]/",$string);//檢查數字是否在開頭
	$check_head_CAPS = preg_match("/^[A-Z]/",$string);//檢查大寫字母是否為開頭
	$check_head_lower = preg_match("/^[a-z]/",$string);//檢查小寫字母是否為開頭
	$check_head_spec = preg_match("/^[^A-Za-z0-9]/",$string);//檢查特殊字元是否為開頭
	$check_end_number = preg_match("/[0-9]$/",$string); //檢查數字是否在結尾
	$check_end_CAPS = preg_match("/[A-Z]$/",$string);//檢查大寫字母是否在結尾
	$check_end_lower = preg_match("/[a-z]$/",$string);//檢查小寫字母是否為結尾
	$check_end_spec = preg_match("/[^A-Za-z0-9]$/",$string);//檢查特殊字元是否為結尾
	$length = strlen($string); //紀錄字串長度
	/*
	0 = 檢查是否包含數字,若包含則為true
	1 = 檢查是否包含英文字母
	2 = 檢查是否包含大寫字母
	3 = 檢查是否包含小寫字母
	4 = 檢查是否包含特殊字元
	5 = 檢查數字是否在開頭
	6 = 檢查大寫字母是否為開頭
	7 = 檢查小寫字母是否為開頭
	8 = 檢查特殊字元是否為開頭
	9 = 檢查數字是否在結尾
	10 = 檢查大寫字母是否在結尾
	11 = 檢查小寫字母是否為結尾
	12 = 檢查特殊字元是否為結尾
	13 = 回傳字串長度
	*/
	$result = array("contain_number"=>$check_contain_number,"contain_letter"=>$check_contain_letter,"check_CAPS"=>$check_CAPS,"check_lower"=>$check_lower,"check_contain_spec"=>$check_contain_spec,"check_head_number"=>$check_head_number,"check_head_CAPS"=>$check_head_CAPS,"check_head_lower"=>$check_head_lower,"check_head_spec"=>$check_head_spec,"check_end_number"=>$check_end_number,"check_end_CAPS"=>$check_end_CAPS,"check_end_lower"=>$check_end_lower,"check_end_spec"=>$check_end_spec,"length"=>$length);
	return $result;
}
function del_somefile_from_database($data,$del_some_thing,$string_obj){  //刪除資料庫檔案若成功則回傳true
	/*
	$data= "XXX.json"
	$del_some_thing = Something you want to delet(array)
	$string_obj = Search criteria
	*/
	$check = false;
	$fileopen = fopen($data,"r");
	$jsondecode = json_decode(fread($fileopen,filesize($data)));
	for($i=0;$i<count($jsondecode);$i++){
		if($jsondecode[$i]->$string_obj == $del_some_thing[$string_obj]){
			array_splice($jsondecode,$i,1);
			$check = true;
		}
	}
	if($check == true){
		$jsondecode = json_encode($jsondecode);
		fclose($fileopen);
		$fileopenX = fopen($data,"w") or die("can't open database");
		fwrite($fileopenX,$jsondecode);
		fclose($fileopenX);
		echo "刪除成功";
		return true;
	}else{
		die("沒有找到此條件,請重新確認輸入");
	}
}
function serch_data_from_database($data,$serch_some_thing,$string_obj){ //搜尋資料庫檔案,若成功則回傳陣列
	$fileopen = fopen($data,"r");
	$filedecode = json_decode(fread($fileopen,filesize($data)));
	$j = 0;
	for($i=0;$i<count($filedecode);$i++){
		if($filedecode[$i]->$string_obj == $serch_some_thing[$string_obj]){
			$result[$j] = $filedecode[$i];
			$j++;
		}
	}
	fclose($fileopen);
	return $result;
	/*
	$result = serch_data_from_database($data,$array,"car");
	echo $result[0]->car;
	*/
}
function read_file($data){ //讀取txt檔案
	$rows = -1;
	$file = fopen($data, "r") or die("請確認檔案是否存在或是否輸入正確");
	while(!feof($file)){	//輸出文本中所有的行，直到文件結束為止。
		$rows++;
		echo fgets($file). "<br />";//當讀出文件一行後，就在後面加上 <br> 讓html知道要換行
	}
	fclose($file);
/*
fopen 是開啟檔案的程式
feof 是檢測是否已到文件末尾
fgets 是讀取文字檔的程式，一次讀一行，直到 /n (分行符號)
*/
}
function getData($url){ //取得txt檔案內的資料,並逐行掃描
	$rows = -1;
	$i = 0;
	$file = fopen($url, "r") or die("請確認檔案是否存在或是否輸入正確");
	while(!feof($file)){	//輸出文本中所有的行，直到文件結束為止。
		$rows++;
		$data[$i] = fgets($file). "<br />";//當讀出文件一行後，就在後面加上 <br> 讓html知道要換行
		$i++;
	}
	fclose($file);
	return $data;
}
function checkdata($url){ //確認要顯示的資料是否大於資料
	$rows = -1;
	$file = fopen($url, "r") or die("請確認檔案是否存在或是否輸入正確");
	while(!feof($file)){	//輸出文本中所有的行，直到文件結束為止。
		$rows++;
		fgets($file). "<br />";//當讀出文件一行後，就在後面加上 <br> 讓html知道要換行
	}
	fclose($file);
	return $rows;
}


/*指令小抄
新增cookie{
	setcookie("user",Cookie value,time()+3600);//設定一個名為user的cookie,壽命3600s
}
刪除cookie{
	setcookie("user","",time()-10);
}
降序
usort($array,"my_sort");
function my_sort($a,$b,$criteria){
	if($a[$criteria]==$b[$criteria])return 0;
	return ($a[$criteria]<$b[$criteria])?-1:1; 
}
*/
?>