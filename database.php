<style type="text/css">
body{
	margin:0px auto;
	text-align:center;
	background:pink;
}
</style>
<?php 
if($_GET["acc"]!=null&&$_GET["password"]!=null){
	$acc = $_GET["acc"];
	$password = $_GET["password"];	
}else{
	die("請輸入帳號密碼");
}
if($acc == "admin"&&$password=="root"){
	echo "<h1>新增帳號與密碼</h1>";
	echo "<form action='add_acc.php' method='GET'>
			<input type='text' name='acc' placeholder='新增帳號名'>
			<input type='password' name='password' placeholder='新增密碼'><br />
			<input type='submit' value='送出'>
 		  </form>";
	echo "<br />";
	echo "<h1>增加帳號存款</h1>";
	echo "<form action='add_money.php' method='GET'>
			<input type='text' name='acc' placeholder='帳號名'>
			<input type='text' name='money' placeholder='金額'><br />
			<input type='submit' value='送出'>
 		  </form>";
	echo "<br />";
	echo "<h1>重置帳號密碼</h1>";
	echo "<form action='reset.php' method='GET'>
			<input type='text' name='acc' placeholder='帳號名'>
			<input type='password' name='rpassword' placeholder='重置的密碼'><br />
			<input type='submit' value='送出'>
 		  </form>";
	echo "<br />";
	echo "<h1>查詢歷史交易</h1>";
	echo "<form action='list.php' method='GET'>
			<input type='text' name='acc' placeholder='帳號名'>
			<input type='submit' value='送出'>
 		  </form>";
}else{
	$zou = serch($acc,$password);
	if($zou == true){
		echo "<h1>查詢餘額</h1>";
		echo "<form action='user_money.php' method='GET'>
				<input type='hidden' name='acc' value = '$acc'><br />
				<input type='submit' value='查詢餘額'>
			</form>";
			echo "<h1>轉帳交易</h1>";
		echo "<form action='user_givemoney.php' method='GET'>
				<input type='hidden' name='acc' value = '$acc'>
				<input type='text' name='hisacc' placeholder='要轉帳的帳號'>
				<input type='text' name='money' placeholder = '金額'><br />
				<input type='submit' value='轉出'>
			</form>";
			echo "<h1>查詢帳戶歷史交易</h1>";
		echo "<form action='time.php' method='GET'>
				<input type='hidden' name='acc' value = '$acc'>
				<input type='submit' value='查詢'>
			</form>";
			
	}
}

function serch($acc,$password){
$checkacc = false;
$checkpss = false;
$data = "database.json";
$fileopen = fopen($data,"r");
$jsondecode = json_decode(fread($fileopen,filesize($data)));
for($i=0;$i<count($jsondecode);$i++){
	if($jsondecode[$i]->uid == $acc){
		$checkacc = true;
		$o = $i;
		$passwordcheck = $jsondecode[$o]->passwordcheck;
	}
	if($jsondecode[$i]->password == $password){
		$checkpss = true;
		
		
	}
	
}

if($checkacc == false){
	fclose($fileopen);
	die("查無帳號");
}else if($checkpss == false &&$jsondecode[$o]->passwordcheck<3 && $checkacc == true){
	$passwordcheck++;
	$jsondecode[$o]->passwordcheck = $passwordcheck;
	$jsonencode = json_encode($jsondecode);
	fclose($fileopen);
	$fileopenX = fopen($data,"w");
	fwrite($fileopenX,$jsonencode);
	fclose($fileopenX);
	die("連續三次輸入密碼錯誤將鎖住帳號");
}
else if($jsondecode[$o]->passwordcheck>=3){
	fclose($fileopen);
	die("帳號已被鎖住,請聯繫管理者");
}else if($checkacc == true &&$jsondecode[$o]->passwordcheck<3&&$checkpss == true){
	$passwordcheck = 0;
	$jsondecode[$o]->passwordcheck = $passwordcheck;
	$jsonencode = json_encode($jsondecode);
	fclose($fileopen);
	$fileopenX = fopen($data,"w");
	fwrite($fileopenX,$jsonencode);
	fclose($fileopenX);
	return true;
}
}
?>