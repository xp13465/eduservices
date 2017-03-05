<?php
/**

 * author:yagas

 * email:yagas60@21cn.com

 */

class Image
{
    /** 类保护变量 */
    protected $th_width    = 100;
    protected $th_height   = 75;
    protected $quality     = 90;   //jpeg图片质量
    protected $transparent = 50;   //水印透明度
    protected $background  = "255,255,255";  //背景颜色

    public $error = "";
    public function __construct(){

    }
    /**
     * 生成缩略图文件
     * @param  $src  原图文件
     * @param  $dst  目标文件
     */
    public function thumb($src,$output=true)
    {
        $thumbConfig = array(
            'width'=>100,
            'height'=>75
        );
        $tinyImg = $this->newImgName($src,"_tiny");
        $result = $this->capture($src,$tinyImg,$thumbConfig,$output);
        return $result;
    }
    /**
     * 按照配置标准,去生成符合规格的图片
     * @param <string> $src 原图路径
     * @param <array> $formatArray 配置标准,例子:
     * @param <array> $changeDefaultSize 是否改变默认图片的尺寸:
     * @param <string> $marksrc 水印图片：/images/mark.gif||mark2.jpg
     * public static $pictureNorm = array(
     1 => array(
     'suffix'=>'_large',
     'width'=>'546',
     'height'=>'364',
     )
     );
     * @return <boolean> 是否生成成功
     */
    public function formatWithPicture($src,$formatArray,$ifMark=false,$changeDefaultSize=true, $marksrc = '/images/mark.png'){
        $sizeArr=getimagesize($src);
        foreach($formatArray as $formatStand) {
            $newImgName = $this->newImgName($src, $formatStand['suffix']);//图片名称
            $max = max(array($formatStand['width'],$formatStand['height']));
            //自动调整缩略宽高
            $config = array();
            if($max == $formatStand['width']){
                $newW = $max;
            }else{
                $newW = $max*$sizeArr[0]/$sizeArr[1];
            }
            $src_im=$this->imageresize($this->IM($src), $newW);//生成最适合切割大小的图片
            //开始剪切图片
            $old_width  = imagesx($src_im);
            $old_height = imagesy($src_im);
			$bg_x =($old_width-$formatStand['width'])/2;
            $bg_y =($old_height-$formatStand['height'])/2;//切割其实位置
			if($old_height>$formatStand['height']){
				$bl=$formatStand['height']/$old_height;
				$bg_x=($formatStand['width']-($old_width*$bl))/2;
				$bg_y =0;//切割其实位置
			}
			if($old_width>$formatStand['width']){
				$bg_x =0;//切割其实位置
			}
            

            $capture = imagecreatetruecolor($formatStand['width'], $formatStand['height']);
			$white=imagecolorallocate($capture, 255, 255, 255); 
			imagefill($capture,0,0,$white); 
            imagecopy ($capture, $src_im,  abs($bg_x), $bg_y,0, 0, $old_width, $old_height);
			// imagecopy ($capture, $src_im, $bg_x, $bg_y, 0, 0, ($formatStand['width']+$bg_x), $formatStand['height']);
            $result = $this->outImage($capture, $newImgName);
            imagedestroy($capture);
            imagedestroy($src_im);
        }
        //判断原图，如果宽不等于800或高不等于600，则要缩小.太大的图片前台不好显示
        if($sizeArr[0]>800||$sizeArr[1]>600){
            $x_percent = 800/$sizeArr[0];
            $y_percent = 600/$sizeArr[1];
            $min_percent = min($x_percent,$y_percent);

            if($min_percent==$x_percent){
                $newW = 800;
            }else{
                $newW = 600*$sizeArr[0]/$sizeArr[1];
            }
            $src_im=$this->imageresize($this->IM($src), $newW);
            $this->outImage($src_im, $src);
            imagedestroy($src_im);
        }
        
        //给原图加水印
        if($ifMark){
            $markSizeArr=getimagesize($_SERVER['DOCUMENT_ROOT'].$marksrc);
            if($markSizeArr[0]<$sizeArr[0]&&$markSizeArr[1]<$sizeArr[1]){
                $this->mark($src,$_SERVER['DOCUMENT_ROOT'].$marksrc,$src);//$newImgName
            }
        }
        
        return true;
    }
    /**
     * 按照配置标准,去生成符合规格的图片
     * @param <string> $src 原图路径
     * @param <array> $formatArray 配置标准,例子:
     *
     * public static $pictureNorm = array(
        1 => array(
            'suffix'=>'_large',
            'width'=>'546',
            'height'=>'364',
        )
    );
     * @return <boolean> 是否生成成功
     */
//    public function formatWithPicture($src,$formatArray,$ifMark=false){
//        $successNum = 0;
//        if($formatArray){
//            $num = count($formatArray);
//            foreach($formatArray as $formatStand){
//                $newImgName = $this->newImgName($src, $formatStand['suffix']);
//                $sizeArr=getimagesize($src);
//                //自动调整缩略宽高
//                if($formatStand['width']/$formatStand['height'] > $sizeArr[0]/$sizeArr[1]){
//                    $newH=$formatStand['height'];
//                    $newW=$newH*$sizeArr[0]/$sizeArr[1];
//                }else{
//                    $newW=$formatStand['width'];
//                    $newH=$newW*$sizeArr[1]/$sizeArr[0];
//                }
//
//                if($sizeArr[0]>$formatStand['width'] || $sizeArr[1]>$formatStand['height'])
//                    $thumbimg=$this->imageresize($this->IM($src), $newW, $newH);
//                else
//                    $thumbimg=$this->IM($src);
//
//                $result=$this->outImage($thumbimg, $newImgName);
//                imagedestroy($thumbimg);
//                if($ifMark && $formatStand['suffix']=='_large'){
//                    $this->mark($newImgName,$_SERVER['DOCUMENT_ROOT'].'/images/mark.png',$newImgName);//$newImgName
//                    $this->mark($src,$_SERVER['DOCUMENT_ROOT'].'/images/mark.png',$src);//$newImgName
//                    $src=$newImgName;//用最大的large代替原图
//                    $ifMark=false;
//                }
//
//                if($result)
//                    $successNum++;
//            }
//            if($successNum==$num)
//                return true;
//        }
//        return false;
//    }
    /**
     * 将图片输出到一个地址
     * @param source $img
     * @param string $fileName
     */
    public function outImage( & $img,$fileName){
        $ext = strtolower(substr($fileName, strripos($fileName,'.')+1));
        switch($ext) {
        case "gif":
        //header('Content-type: image/gif');
            imagegif($img,$fileName);
            break;
        case "jpeg":
        case "jpg":
        //header('Content-type: image/jpeg');
            imagejpeg($img,$fileName,$this->quality);
            break;
        case "png":
        //header('Content-type: image/png');
            imagepng($img,$fileName);
            break;
        default:
            return false;
        }
        return true;
    }
    /**
     * 将过大的图片缩小一点
     * @param <type> $src 原图文件
     * @param <type> $output 是否生成新文件
     * @return <type>
     */
    public function standard($src,$output=false){
        $standardConfig = array(
            'width'=>600,//以宽度为600像素等比例缩放
        );
        $result = $this->scale($src,"",$standardConfig,false);
        return $result;
    }
    /**
     * 根据文件路径得到缩略图的文件路径
     * @param <string> $src 原图文件
     * @return <string> 缩略图文件
     */
    public function newImgName($src,$suffixStr){
        $src=str_replace('_large', '', $src);
        $leftStr = substr($src,0,strrpos($src,"."));
        $rightStr = substr($src,strrpos($src,"."));
        return $leftStr.$suffixStr.$rightStr;
    }
    /**
     * 对图片按百分比进行缩放处理
     * @param  string       $src     原图文件
     * @param  string       $dst     输入的目标文件
     * @param  float/array  $zoom    缩放比例，浮点类型时按百分比绽放，数组类型时按指定大小时行缩放
     * @param  boolean      $output  是否生成文件输出
     */
    public function scale($src, $dst=null, $zoom=1, $output=true)
    {
        
        $result = false;
        if(!file_exists($src)){
            //die('File not exists.');
            $this->error="File not exists.";
            return $result;
        }
           
        if(!$zoom){
            //die('the zoom undefine.');
            $this->error="the zoom undefine.";
            return $result;
        }
        
        $src_im = $this->IM($src);
        $old_width = imagesx($src_im);
    
        if(is_float($zoom)) {
            //按百分比进行缩放
            $new_width  = $old_width * $zoom;
        }elseif(is_array($zoom)) {
            //明确的缩放尺寸
            $new_width  = $zoom['width'];
        }

        //是否定义的缩放的高度
        if(!isset($zoom['height']) || isset($zoom['height']) && !$zoom['height']) {
            //等比例缩放
            $resize_im = $this->imageresize($src_im, $new_width);
        }else{
            //非等比例缩放        
            $resize_im = $this->imageresize($src_im, $new_width, $zoom['height']);
        }

        if(!$output){
            header("Content-type: image/jpeg");
            $result = imagejpeg($resize_im, null, $this->quality);
        }else{
            $new_file = empty($dst)? $src:$dst;
            $result = imagejpeg($resize_im, $new_file, $this->quality);
        }

        imagedestroy($src_im);
        imagedestroy($resize_im);
        return $result;
    }

    /**
     * 对图片进行裁切
     * @param $src    原始文件
     * @param $dst    目标文件
     * @param $config 配置
     * @param $output 是否生成目标文件
     */
    public function capture($src, $dst=null,$config=null, $output=true) {
        $result = false;
        if(!file_exists($src)){
            //die('File not exists.');
            $this->error="File not exists.";
            return $result;
        }
        $iniHeight = array_key_exists('height', $config)?$config['height']:$this->th_height;//初始高度
        $width  = array_key_exists('width', $config)?$config['width']:$this->th_width;//用于计算的宽度
        $height = $iniHeight;//用于计算的高度
        $quality = array_key_exists('quality', $config)?$config['quality']:$this->quality;//用于使用的图片质量
        $background = array_key_exists('background', $config)?$config['background']:$this->background;//用于使用的背景色
        $src_im = $this->IM($src);
        $old_width  = imagesx($src_im);
        $old_height = imagesy($src_im);

        $capture = imagecreatetruecolor($width, $height);
        $rgb = explode(",", $background);
        $white = imagecolorallocate($capture, $rgb[0], $rgb[1], $rgb[2]);
        imagefill($capture, 0, 0, $white);

        //当图片大于缩略图时进行缩放
        if($old_width > $width && $old_height>$height) {
            $resize_im  = $this->imageresize($src_im, $width);
            //图片比例不合规范时，重新计算比例进行裁切
            if(imagesy($resize_im) < $height) {
                $proportion = $old_height/$iniHeight;
                $resize_im = $this->imageresize($src_im, $old_width/$proportion);
            }
            $posx = 0;
            $posy = 0;
        }else{
            //图片小于缩略图时将图片居中显示
            $posx = ($width-$old_width)/2;
            $posy = ($height-$old_height)/2;
            $resize_im = $src_im;
        }

        imagecopy($capture, $resize_im, $posx, $posy, 0, 0, imagesx($resize_im), imagesy($resize_im));

        if(!$output){
            header("Content-type: image/jpeg");
            $result = imagejpeg($capture, null, $quality);
        }else{
            $new_file = empty($dst)? $src:$dst;
            $result = imagejpeg($capture, $new_file, $quality);
        }

        imagedestroy($src_im);
        @imagedestroy($resize_im);
        imagedestroy($capture);
        return $result;
    }

    /**
     * 写入水印图片
     * @param <string> $src 需要写入水印的图片
     * @param <string> $mark 水印图片
     * @param <string> $dst 输出图片地址
     * @param <boolean> $output 是否生成文件输出
     * @return <boolean>
     */
    public function mark($src, $mark, $dst='', $output=true)
    {

        $result = false;
        
        if(!file_exists($src) || !file_exists($mark)){
            $this->error="File not exists.";
            return $result;
        }
        $mark_info = getimagesize($mark);
        $src_info  = getimagesize($src);
        list($mw,$mh) = $mark_info;
        list($sw,$sh) = $src_info;
        if($sw/$mw < 1.5 || $sh/$mh < 1.5){//图片太小不打水印
            return false;
        }
        $px = $sw - $mw -5;
        $py = $sh - $mh -5;

        $im = $this->IM($src);
        $mim = $this->IM($mark);

        if($im==null || $mim==null){
            return $result;
        }
        if(preg_match('/\.png$/i', $mark))
            $this->alpha_blending($im,$mim,$px,$py);
        else
            imagecopymerge($im, $mim, $px, $py, 0, 0, $mw, $mh, $this->transparent);
        if($output){
            $new_file = empty($dst)? $src:$dst;
            $result = imagejpeg($im, $new_file, $this->quality);
        }else{
            header('Content-type: image/jpeg');
            $result = imagejpeg($im);
        }
        imagedestroy($im);
        imagedestroy($mim);
        return $result;
    }
    /**
     * 带alpha通道打水印
     * @param source $dest   需要水印的图片
     * @param source $source png水印资源
     * @param int $dest_x    x偏移
     * @param int $dest_y    y偏移
     */
    public function alpha_blending (&$dest, &$source, $dest_x, $dest_y) {
        for ($y = 0; $y < imagesy($source); $y++) {
            for ($x = 0; $x < imagesx($source); $x++) {

                $argb_s = imagecolorat ($source, $x, $y);
                $argb_d = imagecolorat ($dest, $x+$dest_x, $y+$dest_y);

                $a_s    = ($argb_s>>24) << 1; ## 7 to 8 bits.
                $r_s    =  $argb_s>>16 & 0xFF;
                $g_s    =  $argb_s>>8 & 0xFF;
                $b_s    =  $argb_s & 0xFF;

                $r_d    =  $argb_d >> 16 & 0xFF;
                $g_d    =  $argb_d >> 8 & 0xFF;
                $b_d    =  $argb_d & 0xFF;

                ## source pixel 100% opaque (alpha == 0)
                if ($a_s == 0) {
                    $r_d = $r_s; $g_d = $g_s; $b_d = $b_s;
                }
                ## source pixel 100% transparent (alpha == 255)
                else if ($a_s > 253) {
                ## using source alpha only, we have to mix (100-"some") percent
                ## of source with "some" percent of destination.
                } else {
                    $r_d = (($r_s * (0xFF-$a_s)) >> 8) + (($r_d * $a_s) >> 8);
                    $g_d = (($g_s * (0xFF-$a_s)) >> 8) + (($g_d * $a_s) >> 8);
                    $b_d = (($b_s * (0xFF-$a_s)) >> 8) + (($b_d * $a_s) >> 8);
                }

                $rgb_d = imagecolorallocatealpha ($dest, $r_d, $g_d, $b_d, $this->transparent);
                imagesetpixel ($dest, $x+$dest_x, $y+$dest_y, $rgb_d);
            }
        }
    }

    /**
     * 通过文件，获取不同的GD对象
     */
    protected function IM($file)
    {
        if(!file_exists($file)){
            $this->error="File not exists.";
            return null;
        }
        $info = getimagesize($file);
        switch($info['mime'])
        {
            case 'image/gif':
                $mim = imagecreatefromgif($file);
                break;
            case 'image/png':
                $mim = imagecreatefrompng($file);
                imagealphablending($mim, false);
                imagesavealpha($mim, true);
                break;
            case 'image/jpeg':
                $mim = imagecreatefromjpeg($file);
                break;
            default:
                $this->error="File format errors.";
                return null;
        }
        return $mim;
    }

    /**
     * 对图片进行缩放的处理
     * @param resource $src_im 图像GD对象
     * @param integer  $width  图片的宽度
     * @param integer  $height 图片的高度，如果不设置高度，将对图片进行等比例缩放
     * @return resuorce $im    返回一个GD对象
     */
    protected function imageresize($src_im, $width, $height=null) {
        $old_width  = imagesx($src_im);
        $old_height = imagesy($src_im);
        $proportion = $old_width/$old_height;
        $new_width = $width;
        $new_height = is_null($height)? round($new_width / $proportion):$height;
        $im  = imagecreatetruecolor($new_width, $new_height);
        $rgb = explode(",", $this->background);
        $white = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
        imagefill($im, 0, 0, $white);
        imagecopyresampled($im, $src_im, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
        //imagecopyresized($im, $src_im, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
        return $im;
    }


    /**
     * 类变量赋值
     */
    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    /**
     * 获取类变量值
     */
    public function __get($key)
    {
        return $this->$key;
    }
}
?>