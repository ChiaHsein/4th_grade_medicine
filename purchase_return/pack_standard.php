<?php
$dbhost = '120.105.161.205';   //IP位址
$dbuser = 'U029'; //使用者帳號
$dbpass = 'U029'; //使用者密碼
$dbname = '4thgradedrugs'; //資料庫名稱
$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); //連資料庫哦~~~~
mysqli_query($connect,"SET NAMES 'UTF8'"); //各種設定
$datetime = date("Ymd",mktime(date('H')+6, date('i'), date('s'), date('m'), date('d'), date('Y')));

$category_code=$_POST["category_code"];

if($category_code=="P")
	$pack_standard = "select * from `pack_standard_table` where P='1';";
else if($category_code=="R")
	$pack_standard = "select * from `pack_standard_table` where R='1';";
else if($category_code=="S")
	$pack_standard = "select * from `pack_standard_table` where S='1';";

$pack_standard_rs=mysqli_query($connect,$pack_standard);


$type ="00";  //如果打$type=""; 下面的strcmp會回傳Boolean值2 ??? 布林怎麼會有2?!
echo "<option>-----</option>";
while($row=mysqli_fetch_array($pack_standard_rs,MYSQLI_ASSOC)){
	$x=substr($row["pack_standard_code"],0,2);
	switch ($x%4) {
		case 0:
			$color="background:#FFDD55;";
			break;
		case 1:
			$color="background:#FFFF77;";
			break;
		case 2:
			$color="background:#DDFF77;";
			break;
		case 3:
			$color="background:#BBFFEE;";
			break;
	}
	if (strcmp($x,$type)==1) {
		if (!is_null($type)) {
			echo '</optgroup>';
		}
		echo "<optgroup label='".$row['type']."' style='".$color."'>";
	}
	echo "<option value='" . $row["pack_standard_code"] . "' style='".$color."'>".$row["pack_standard_code"].":".$row["pack_standard"]."</option>";
	$type = substr($row["pack_standard_code"],0,2); 

}
if ($type !="") {
    echo '</optgroup>';
}








?>