<?php
$file_name = $_GET["file"];
	 
    $file_dir = "./Excel/";
	$file_dir2 = "./Daily_Excel/";
	$file_dir3 = "./files/";
    //检查文件是否存在    
    if (!file_exists ($file_dir.$file_name)) { 
		if (!file_exists ($file_dir2.$file_name)){
			if (!file_exists ($file_dir3.$file_name)){
				echo "文件找不到";    
				exit ();
			}else{
				header("Content-Type: application/force-download");//强制下载
				//给下载的内容指定一个中文名字
				header('Content-Disposition: attachment; filename="' . $file_name . '";');
				readfile($file_dir3.$file_name); 
			}
		}else{
			 header("Content-Type: application/force-download");//强制下载
			//给下载的内容指定一个中文名字
			header('Content-Disposition: attachment; filename="' . $file_name . '";');
			readfile($file_dir2.$file_name); 
		}		
    } else {    
        header("Content-Type: application/force-download");//强制下载
        //给下载的内容指定一个中文名字
        header('Content-Disposition: attachment; filename="' . $file_name . '";');
        readfile($file_dir.$file_name); 
    }    

?>