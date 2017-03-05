<?php
/**
 * KindEditor PHP
 * 
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 * 
 */

require_once 'JSON.php';
//文件保存目录路径
$save_path = '../../../userfiles/';
//文件保存目录URL
$save_url = '/userfiles/';
//定义允许上传的文件扩展名
$ext_arr = array('gif', 'jpg', 'jpeg', 'png');
//最大文件大小
$max_size = 5*1024*1024;

$maxWidth="900";

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("临时文件可能不是上传文件。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		$sizes=($max_size/1024/1024)."M";
		alert("上传文件大小超过限制{$sizes}。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr) === false) {
		alert("上传文件扩展名是不允许的扩展名。");
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	
	
	$info = getimagesize($file_path);
        switch($info['mime'])
        {
            case 'image/gif':
                $mim = imagecreatefromgif($file_path);
                break;
            case 'image/png':
                $mim = imagecreatefrompng($file_path);
                imagealphablending($mim, false);
                imagesavealpha($mim, true);
                break;
            case 'image/jpeg':
                $mim = imagecreatefromjpeg($file_path);
                break;
        }
	
	$old_width  = imagesx($mim);
    $old_height = imagesy($mim);
	if($old_width>$maxWidth){
		$newbili=$maxWidth/$old_width;
		$new_hight=$newbili*$old_height;
	$im  = imagecreatetruecolor($maxWidth, $new_hight);
	imagecopyresampled($im, $mim, 0, 0, 0, 0,$maxWidth, $new_hight, $old_width, $old_height);
	
	$ext = strtolower(substr($file_path, strripos($file_path,'.')+1));
	
        switch($ext) {
        case "gif":
        header('Content-type: image/gif');
            imagegif($im,$file_path);
            break;
        case "jpeg":
        case "jpg":
        header('Content-type: image/jpeg');
            imagejpeg($im,$file_path,100);
            break;
        case "png":
        header('Content-type: image/png');
            imagepng($im,$file_path );
            break;
        }
		
	}
	
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;
	
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>