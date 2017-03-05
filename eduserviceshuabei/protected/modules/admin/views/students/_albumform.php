<?php 
$action = $this->getAction()->getId(); 

$url=Yii::app()->createUrl("admin/students/outstudents",array("type"=>"1"));
if($action=="manage"){
$url=Yii::app()->createUrl("admin/students/outstudentsmanage",array("type"=>"3"));
}
?>
<form id="explodeExcel" action='<?=$url?>' target="_blank" method="post">

    <table width="500px">
        <tr style="line-height: 35px;">
            <td align="right" width="120px">入学考批次选择：</td>
            <td align="left" >
            <input name='order' type='hidden' value='<?=isset($_GET['order'])?$_GET['order']:"";?>'/>
				<input name='studentsids' type='hidden' value=''/>
                <?php 
				echo CHtml::dropDownList('pc','', Pici::model()->getAllPC(false,true),
				array(
				'class'=>"wauto",
				'empty'=>'全部',
				));
				?>
            </td>
        </tr>
        <tr style="line-height: 35px;">
            <td align="right" width="120px">考试情况</td>
            <td align="left" >
				 <?php 
                $marktypetmp=isset($_GET['marktype'])?$_GET['marktype']:"";
                echo CHtml::dropDownList('marktype',$marktypetmp, array(1=>"已考",2=>"未考"),
                array(
                'class'=>"wauto",
                'empty'=>'考试情况',
                ));
          ?>
            </td>
        </tr>
       
        <tr style="line-height: 35px;">
            <td align="right" >录入批次选择：</td>
            <td align="left">
               <?php 
               // $model= Students::model()->findAll("1=1 group by s_rpc");               
               // print_r($model);exit;
               // $array=array();
               // foreach($model as $val)$array[$val->s_rpc?$val->s_rpc:"999"]=$val->s_rpc?$val->s_rpc:"无批次";
                  
                $array= Students::model()->getSrpc();        
				echo CHtml::dropDownList('rpc','', $array,
				array(
				'class'=>"wauto",
				'empty'=>'全部',
				));
				?>
            </td>
        </tr>
        
        <tr>
            <td align="right" >所属：</td>
            <td align="left">
        <?php if(isset($type)&&$type=="sm"){?>
        
        <?php 
        $zxtmp=isset($_POST['pid'])&&$_POST['pid']?$_POST['pid']:"";
        $bmtmp=isset($_POST['baomingdian'])&&$_POST['baomingdian']?$_POST['baomingdian']:"";
        $jgtmp=isset($_POST['jigou'])&&$_POST['jigou']?$_POST['jigou']:"";
        $uid=Yii::app()->user->id;
		$usermodel=User::model()->findByPk($uid);
        if(Yii::app()->user->role==3){
            $zxtmp=$usermodel->user_organization;
        }else if(Yii::app()->user->role==2){
            $bmtmp=$usermodel->user_organization;
        }
        
        if(Yii::app()->user->role=='4'){
            echo CHtml::dropDownList('pid',$zxtmp, Organization::model()->getOrByPid(0),
            array(
                'name'=>'pid',
                'empty'=>'全部',
                'class'=>"wauto",
                'ajax' => array(
                'type'=>'GET', 
                'url'=>CController::createUrl('admin/getorganization'),
                'update'=>'#baomingdian', 
                'data'=>array('pid'=>"js:this.value",'typeid'=>1)
            )));
            echo "<br/>";
        }
        if(in_array(Yii::app()->user->role,array(3,4))){
            $datas=$zxtmp?Organization::model()->getOrByPid($zxtmp):array();
            echo CHtml::dropDownList('baomingdian',$bmtmp, $datas,
            array(	
                'name'=>'baomingdian',
                'empty'=>'全部',
                'class'=>"wauto",
                'ajax' => array(
                'type'=>'GET', 
                'url'=>CController::createUrl('admin/getorganization'),
                'update'=>'#jigou', 
                'data'=>array('pid'=>"js:this.value",'typeid'=>2)
                )
            ));
            echo "<br/>";
        }
        if(in_array(Yii::app()->user->role,array(2,3,4))){
            $datas=$bmtmp?Organization::model()->getOrByPid($bmtmp):array();
            echo CHtml::dropDownList('jigou',$jgtmp, $datas,
            array(	
                'name'=>'jigou',
                'empty'=>'全部',
                'class'=>"wauto",
            ));
        }
        ?>
        <?php }else{?>
                <?php 
					if(Yii::app()->user->role=="4"){
						$getID=0;
					}else{
						$uid=Yii::app()->user->id;
						$usermodel=User::model()->findByPk($uid);
						$getID=$usermodel->user_organization;
					}
					$Oarr=Organization::model()->getAllC($getID);
					// print_r($Oarr);
					echo CHtml::dropDownList('pid','', $Oarr,
					array(
					'class'=>"wauto",
					'empty'=>'全部',
					));?>
         
        <?php }?>
           </td>
        </tr>
        <tr>
            <td align="right" >审核状态选择：</td>
            <td align="left">
                <?php 
				echo CHtml::dropDownList('status','', Students::$status,
				array(
				'class'=>"wauto",
				'empty'=>'审核状态',
				));
				?>
            </td>
        </tr>
        <tr>
            <td align="right" >导出类型选择：</td>
            <td align="left">
                <?php 
				echo CHtml::dropDownList('exolodetype','1', array("1"=>"导入表","2"=>"照片"),
				array(
                    'class'=>"wauto",
				));
				?>
            </td>
        </tr>
    </table>
</form>
<script>
function createAlbum(){
           var content = "<div id='alertform'>"+$("#albumform").html()+"</div>";
            jw.pop.customtip(
            "导出数据-默认导出全部",
            content,
            {
                hasBtn_ok:true,
                hasBtn_cancel:true,
                zIndex:10000,
                ok: function(){
                   
					$("#alertform form").submit();
					// mark._hide()
					return false;
                    
                },
                btn_float:"center"
            }
        );
    }
</script>
