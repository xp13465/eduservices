<?php

class DefaultController extends Controller
{
    public $layout='column2';
    public function actionIndex()
	{
        
        // echo 3;exit;
        $this->render('index',array(
            // 'sellPrice'=>$sellPrice,
            // 'rentPrice'=>$rentPrice,
            // 'model'=>$model,
            // 'type'=>$type,
            // 'id'=>$id,
            // 'title'=>$title,
        ));
    }
	public function actionGetNews()
	{
		$url="http://www.beihangonline.com/openwindow/new.html";
        // $url="http://www.beihangonline.com/openwindow/affiche.html";
        // $url="http://www.beihangonline.com/openwindow/info.html";
        $contents=file_get_contents($url);
        $contents=iconv("gbk","utf-8",$contents);
        $proArr=@explode('<table',$contents);

        $proArr1=explode('2011-05-13',$proArr[16]);

        // print_r("<table ".$proArr1[0]."</table>");
        
        // echo $contents;
        // echo "<pre>";

        // $vv=preg_match_all('|<dd class="tit">(.*?)</dd>|', $contents, $r);
        $vv=preg_match_all('|<a href="(.*?)".*?>(.*?)</a>|', $proArr1[0], $r);
        $test=@explode('<a href="',$proArr1[0]);
        $URLARR=array();
        foreach($test as $k=>$value){
            if($k<1)continue;
           $testArr=explode("</a>",$value);
           $temp=explode(">",$testArr[0]);;
           $URLARR[$k]['title']=$temp[1];
           $temp=explode("\"",$testArr[0]);;
           $URLARR[$k]['url']=$temp[0];
         
        }
          
        // print_r($r[1]);
        foreach($URLARR as $key=>$val){
           
            $vcon=file_get_contents("http://www.beihangonline.com/openwindow/{$val['url']}");
            $vcon=iconv("gbk","utf-8",$vcon);
            // echo $vcon;
            $vconArr=@explode('<table',$vcon);
            // print_r($vconArr[16]);
            
            // print_r($vconArr[17] );
            // $vssss=preg_match_all('|<td width="573"  align="right">(.*?)</td>|', $vconArr[17], $ssss);
              // print_r($ssss);
            // exit;
            $vconArr1=@explode('<div class=',$vconArr[17]);
             unset($vconArr1[0]);
            $ccc="<div class=".join("",$vconArr1 );
            $vconArr1=@explode('</td>',$ccc);
           
            
           
            $vconArr2=@explode('<td height="28">',$vconArr[16]);
            if(!isset($vconArr2[1])){
               continue;
            }
             $vtime=preg_match_all('|<td align="center"><span class="STYLE11">(.*?)</span>|', $vconArr2[1], $rtime);
            // $vconArr2=@explode('</td>',$vconArr2[1]);
            
            
          
            
            
            // $CDbCriteria=new CDbCriteria();
            // $CDbCriteria->addColumnCondition($array);
            
            // $count=$dblink->count("collocation",$CDbCriteria);
          
            $news=new Information();
            $news['i_class']='1';
            $news['i_title']=$val['title'];
            $news['i_con']=$vconArr1[0];
            $time=$rtime[1][0]?strtotime($rtime[1][0]):0;
            $news['i_submitdate']=$time;
            $news['i_updatetime']=$time;
            $news['i_form']="北航现代远程教育学院";
            $news['i_author']="管理员";
                $num=Information::model()->count("i_title ='{$news['i_title']}'  and i_author ='{$news['i_author']}'");
            if(!$num){
                if($news->save()){
                    echo $news['i_title']."抓取成功<br/>";
                }else{
                    print_r($news->errors)."<br/>";
                }
            }else{
                echo $news['i_title']."|||已存在<br/>";
            }
            
            
        }
    }
}