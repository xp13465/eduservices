<?php
class Common{
    public static  $ChineseNumber=array(
        0=>'零',
        1=>'一',
        2=>'二',
        3=>'三',
        4=>'四',
        5=>'五',
        6=>'六',
        7=>'七',
        8=>'八',
        9=>'九',
        10=>'十',
        
    );
    /**
     *截取字符串
     * @param <type> $string 输入字符串
     * @param <type> $length 长度
     * @param <type> $dot 超过长度时后缀
     * @param <type> $charset编码
     * @return <type> 
     */
    public static function strCut($string, $length, $dot = '...',$charset='utf-8'){
        $strlen = strlen($string);
        if($strlen <= $length) {
            return $string;
        }
        $strcut = '';
        if(strtolower($charset) == 'utf-8'){
            $n = $tn = $noc = 0;
            while($n < $strlen){
                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                }else if(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                }else if(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 3;
                }else if(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 4;
                }else if(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 5;
                }else if($t == 252 || $t == 253){
                    $tn = 6; $n += 6; $noc += 6;
                }else{
                    $n++;
                }
                if($noc >= $length) {
                    break;
                }
            }
            if($noc > $length){
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
            $strcut = $strcut.$dot;
        }else{
            $dotlen = strlen($dot);
            $maxi = $length - $dotlen - 1;
            for($i = 0; $i < $maxi; $i++){
                $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
            }
        }
        return $strcut;
    }
	 public static function getYear($num="20"){
		$YearArr=array();
		for($num=0;$num<=20;$num++){
			$YearDate=date("Y",strtotime("-{$num} Year"));
			$YearArr[$YearDate]=$YearDate;
		}
		return($YearArr);
	 }
     
    public static function getSemester($semester=""){
        $str='';
		if($semester){
            $str=1;
            for($i=6;$i<120;$i+=6){
                if(strtotime("-{$i} month")<=strtotime("20".$semester."01")){
                    break;
                }else{
                    $str++;
                }
            }
        }
		return($str);
	 }
      public static function getXueqi(){
            $XUEQI=0;
            if(in_array(date('m'),Yii::app()->params->pcchun)){
                if(in_array(date('m'),array(1,2))){
                    $XUEQI=date("y",strtotime("-1 year"))."09";
                }else{
                    $XUEQI=date("y")."09";
                }
            }else if(in_array(date('m'),Yii::app()->params->pcqiu)){
                $XUEQI=date("y")."03";
            }
            return($XUEQI);
     }
    public static function getRuPiCi(){
        $RPC='';
        if(in_array(date('m'),Yii::app()->params->pcchun)){
            if(in_array(date('m'),array(9,10,11,12))){
                $RPC=date("y",strtotime("+1 year"))."03";
            }else{
                $RPC=date("y")."03";
            }
        }else if(in_array(date('m'),Yii::app()->params->pcqiu)){
            $RPC=date("y")."09";
        }
        return($RPC);
    }
}
?>