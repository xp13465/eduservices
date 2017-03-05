<div class="clear">
    <form class="margin0" action=""  onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/admin/statistics")?>')">  
    <span>搜索：</span>
    
    <?php 
        $zxtmp=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
        
           
        $array= Students::model()->getSrpc();   
	    $rpctmp=isset($_GET['s_rpc'])?$_GET['s_rpc']:"";
		echo CHtml::dropDownList('s_rpc',$rpctmp, $array,
		array(
		'class'=>"wauto",
		'empty'=>'入学批次',
		));
         echo CHtml::dropDownList('zhongxin',$zxtmp, Organization::model()->getOrByPid(0),
         array(
             'name'=>'zhongxin',
             'empty'=>'请选择所属学习中心',
             'class'=>"wauto"
         ));
	  ?>
       
    <button type="submit" class="btn btn-inverse serach">搜索</button>
    </form>
</div>

<style>
table.info tbody tr.zxtr td{text-align:left}
table.info tbody tr.bmtr td{text-align:left}
table.info tbody tr.jgtr td{text-align:left}
</style>
<?php
        $this->breadcrumbs=array("统计");
        
        $criteria=new CDbCriteria;
        $pici=isset($_GET['s_rpc'])&&$_GET['s_rpc']?$_GET['s_rpc']:"";
        $zhongxin=isset($_GET['zhongxin'])&&$_GET['zhongxin']?$_GET['zhongxin']:"";
        if($zhongxin){
            $criteria->addCondition("o_id ='{$zhongxin}' ");
        }else{
            $criteria->addCondition("o_pid in(0) ");
        }
        $criteria->addCondition("o_isdel =1 ");
		$zhongxinModels=Organization::model()->findAll($criteria);
?>
<div>
    <table class="table table-bordered info specialtylist" width="100%">
    <thead>
        <tr class="info-center">
            <th>学习中心</th>
            <th width="130px">待审核</th>
            <th width="130px">已审核</th>
            <th width="130px">已驳回</th>
            <th width="130px">待确认</th>
            <th width="130px">已录取</th>
            <th width="130px">不录取</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $shenheTotal=$luquTotal=$bohuiTotal=$SMdqrTotal=$SMylqTotal=$SMblqTotal=array();
        foreach($zhongxinModels as $zhongxinModel){
            $zxxOarr=Organization::model()->getAllid($zhongxinModel->o_id);
            $zxxUarr=User::model()->getAllByOid($zxxOarr);
            $shenheNUM=Students::model()->getNum($zxxUarr,2,1,$pici);
            $luquNUM=Students::model()->getNum($zxxUarr,2,2,$pici);
            $bohuiNUM=Students::model()->getNum($zxxUarr,2,3,$pici);
            $SMdqrNUM=Students::model()->getNum($zxxUarr,1,1,$pici);
            $SMylqNUM=Students::model()->getNum($zxxUarr,1,2,$pici);
            $SMblqNUM=Students::model()->getNum($zxxUarr,1,3,$pici);
            
            @$shenheTotal[$zhongxinModel->o_id]+=$shenheNUM;
            @$luquTotal[$zhongxinModel->o_id]+=$luquNUM;
            @$bohuiTotal[$zhongxinModel->o_id]+=$bohuiNUM;
            @$SMdqrTotal[$zhongxinModel->o_id]+=$SMdqrNUM;
            @$SMylqTotal[$zhongxinModel->o_id]+=$SMylqNUM;
            @$SMblqTotal[$zhongxinModel->o_id]+=$SMblqNUM;
            
            @$shenheTotal['all']+=$shenheNUM;
            @$luquTotal['all']+=$luquNUM;
            @$bohuiTotal['all']+=$bohuiNUM;
            @$SMdqrTotal['all']+=$SMdqrNUM;
            @$SMylqTotal['all']+=$SMylqNUM;
            @$SMblqTotal['all']+=$SMblqNUM;
            
           $baomingModels=Organization::model()->getOrByPid($zhongxinModel->o_id);
        ?>
        <tr  attr="bmp<?=$zhongxinModel->o_id?>" class="btnshow zxtr">
            <td><?php if($baomingModels){?><a href='javascript:void(0)' attr="bmp<?=$zhongxinModel->o_id?>" class='btnshow'></a><?php }?><?=$zhongxinModel->o_name?>&nbsp;(录入：<span class='ycolor'><?=$shenheNUM+$luquNUM+$bohuiNUM+$SMdqrNUM+$SMylqNUM+$SMblqNUM?></span>&nbsp;(录取：<span class='ycolor'><?=$SMylqNUM?></span>)</td>
            <td><?=$shenheNUM?></td>
            <td><?=$luquNUM?></td>
            <td><?=$bohuiNUM?></td>
            <td><?=$SMdqrNUM?></td>
            <td><?=$SMylqNUM?></td>
            <td><?=$SMblqNUM?></td>
        </tr>
<?php       
            foreach($baomingModels as $bmid=>$baomingname){
            // echo "--".$baomingname;
            $bmxOarr=Organization::model()->getAllid($bmid);
            $bmxUarr=User::model()->getAllByOid($bmxOarr);
            $shenheNUM=Students::model()->getNum($bmxUarr,2,1,$pici);
            $luquNUM=Students::model()->getNum($bmxUarr,2,2,$pici);
            $bohuiNUM=Students::model()->getNum($bmxUarr,2,3,$pici);
            $SMdqrNUM=Students::model()->getNum($bmxUarr,1,1,$pici);
            $SMylqNUM=Students::model()->getNum($bmxUarr,1,2,$pici);
            $SMblqNUM=Students::model()->getNum($bmxUarr,1,3,$pici); 
            
            @$shenheTotal[$bmid]+=$shenheNUM;
            @$luquTotal[$bmid]+=$luquNUM;
            @$bohuiTotal[$bmid]+=$bohuiNUM;
            @$SMdqrTotal[$bmid]+=$SMdqrNUM;
            @$SMylqTotal[$bmid]+=$SMylqNUM;
            @$SMblqTotal[$bmid]+=$SMblqNUM;
            
            $jigouModels=Organization::model()->getOrByPid($bmid);
?>
    <tr attr="jgp<?=$bmid?>" class="btnshow hide bmtr bmp<?=$zhongxinModel->o_id?>">
            <td><?php if($jigouModels){?><a href='javascript:void(0)' attr="jgp<?=$bmid?>" class='btnshow'></a><?php }?><?="<span class='hcolor1'>········</span>".$baomingname?>&nbsp;(录入：<span class='ycolor'><?=$shenheNUM+$luquNUM+$bohuiNUM+$SMdqrNUM+$SMylqNUM+$SMblqNUM?></span>&nbsp;(录取：<span class='ycolor'><?=$SMylqNUM?></span>)</td>
            <td><?="<span class='hcolor1'>······</span>".$shenheNUM?></td>
            <td><?="<span class='hcolor1'>······</span>".$luquNUM?></td>
            <td><?="<span class='hcolor1'>······</span>".$bohuiNUM?></td>
            <td><?="<span class='hcolor1'>······</span>".$SMdqrNUM?></td>
            <td><?="<span class='hcolor1'>······</span>".$SMylqNUM?></td>
            <td><?="<span class='hcolor1'>······</span>".$SMblqNUM?></td>
    </tr>
<?php          
                foreach($jigouModels as $jgid=>$jigouname){
                    // echo "<span class='hcolor1'>············</span>".$jigouname;
                    $jgxOarr=Organization::model()->getAllid($jgid);
                    $jgxUarr=User::model()->getAllByOid($jgxOarr);
                    $shenheNUM=Students::model()->getNum($jgxUarr,2,1,$pici);
                    $luquNUM=Students::model()->getNum($jgxUarr,2,2,$pici);
                    $bohuiNUM=Students::model()->getNum($jgxUarr,2,3,$pici);
                    $SMdqrNUM=Students::model()->getNum($jgxUarr,1,1,$pici);
                    $SMylqNUM=Students::model()->getNum($jgxUarr,1,2,$pici);
                    $SMblqNUM=Students::model()->getNum($jgxUarr,1,3,$pici);  
                        
                    @$shenheTotal[$jgid]+=$shenheNUM;
                    @$luquTotal[$jgid]+=$luquNUM;
                    @$bohuiTotal[$jgid]+=$bohuiNUM;
                    @$SMdqrTotal[$jgid]+=$SMdqrNUM;
                    @$SMylqTotal[$jgid]+=$SMylqNUM;
                    @$SMblqTotal[$jgid]+=$SMblqNUM;
?>

       <tr  class="hide jgtr jgp<?=$bmid?> bmp<?=$zhongxinModel->o_id?>">
            <td><?="<span class='hcolor1'>·················</span>".$jigouname?>&nbsp;(录入：<span class='ycolor'><?=$shenheNUM+$luquNUM+$bohuiNUM+$SMdqrNUM+$SMylqNUM+$SMblqNUM?></span>&nbsp;(录取：<span class='ycolor'><?=$SMylqNUM?>)</span></td>
            <td><?="<span class='hcolor1'>············</span>".$shenheNUM?></td>
            <td><?="<span class='hcolor1'>············</span>".$luquNUM?></td>
            <td><?="<span class='hcolor1'>············</span>".$bohuiNUM?></td>
            <td><?="<span class='hcolor1'>············</span>".$SMdqrNUM?></td>
            <td><?="<span class='hcolor1'>············</span>".$SMylqNUM?></td>
            <td><?="<span class='hcolor1'>············</span>".$SMblqNUM?></td>
        </tr>

<?php           } ?>
    <?php if($jigouModels){?>
        <tr  class="info-center hide jgtr jgp<?=$bmid?>">
            <td><span class='hcolor1'>················</span><b>合计:</b>&nbsp;(录入：<span class='ycolor'><?=$shenheTotal[$bmid]+$luquTotal[$bmid]+$bohuiTotal[$bmid]+$SMdqrTotal[$bmid]+$SMylqTotal[$bmid]+$SMblqTotal[$bmid]?></span>&nbsp;(录取：<span class='ycolor'><?=$SMylqTotal[$bmid]?>)</span></td>
            <td><span class='hcolor1'>············</span><?=$shenheTotal[$bmid]?>&nbsp;/&nbsp;<?=$shenheTotal[$bmid]+$luquTotal[$bmid]+$bohuiTotal[$bmid]?></td>
            <td><span class='hcolor1'>············</span><?=$luquTotal[$bmid]?>&nbsp;/&nbsp;<?=$shenheTotal[$bmid]+$luquTotal[$bmid]+$bohuiTotal[$bmid]?></td>
            <td><span class='hcolor1'>············</span><?=$bohuiTotal[$bmid]?>&nbsp;/&nbsp;<?=$shenheTotal[$bmid]+$luquTotal[$bmid]+$bohuiTotal[$bmid]?></td>
            <td><span class='hcolor1'>············</span><?=$SMdqrTotal[$bmid]?>&nbsp;/&nbsp;<?=$SMdqrTotal[$bmid]+$SMylqTotal[$bmid]+$SMblqTotal[$bmid]?></td>
            <td><span class='hcolor1'>············</span><?=$SMylqTotal[$bmid]?>&nbsp;/&nbsp;<?=$SMdqrTotal[$bmid]+$SMylqTotal[$bmid]+$SMblqTotal[$bmid]?></td>
            <td><span class='hcolor1'>············</span><?=$SMblqTotal[$bmid]?>&nbsp;/&nbsp;<?=$SMdqrTotal[$bmid]+$SMylqTotal[$bmid]+$SMblqTotal[$bmid]?></td>
        </tr>
    <?php       } ?>
<?php       } ?>
    <?php if($baomingModels){?>
    <tr  class="info-center hide bmtr bmp<?=$zhongxinModel->o_id?>">
            <td><span class='hcolor1'>········</span><b>合计:</b>&nbsp;(录入：<span class='ycolor'><?=$shenheTotal[$zhongxinModel->o_id]+$luquTotal[$zhongxinModel->o_id]+$bohuiTotal[$zhongxinModel->o_id]+$SMdqrTotal[$zhongxinModel->o_id]+$SMylqTotal[$zhongxinModel->o_id]+$SMblqTotal[$zhongxinModel->o_id]?></span>&nbsp;(录取：<span class='ycolor'><?=$SMylqTotal[$zhongxinModel->o_id]?>)</span></td>
            <td><span class='hcolor1'>······</span><?=$shenheTotal[$zhongxinModel->o_id]?>&nbsp;/&nbsp;<?=$shenheTotal[$zhongxinModel->o_id]+$luquTotal[$zhongxinModel->o_id]+$bohuiTotal[$zhongxinModel->o_id]?></td>
            <td><span class='hcolor1'>······</span><?=$luquTotal[$zhongxinModel->o_id]?>&nbsp;/&nbsp;<?=$shenheTotal[$zhongxinModel->o_id]+$luquTotal[$zhongxinModel->o_id]+$bohuiTotal[$zhongxinModel->o_id]?></td>
            <td><span class='hcolor1'>······</span><?=$bohuiTotal[$zhongxinModel->o_id]?>&nbsp;/&nbsp;<?=$shenheTotal[$zhongxinModel->o_id]+$luquTotal[$zhongxinModel->o_id]+$bohuiTotal[$zhongxinModel->o_id]?></td>
            <td><span class='hcolor1'>······</span><?=$SMdqrTotal[$zhongxinModel->o_id]?>&nbsp;/&nbsp;<?=$SMdqrTotal[$zhongxinModel->o_id]+$SMylqTotal[$zhongxinModel->o_id]+$SMblqTotal[$zhongxinModel->o_id]?></td>
            <td><span class='hcolor1'>······</span><?=$SMylqTotal[$zhongxinModel->o_id]?>&nbsp;/&nbsp;<?=$SMdqrTotal[$zhongxinModel->o_id]+$SMylqTotal[$zhongxinModel->o_id]+$SMblqTotal[$zhongxinModel->o_id]?></td>
            <td><span class='hcolor1'>······</span><?=$SMblqTotal[$zhongxinModel->o_id]?>&nbsp;/&nbsp;<?=$SMdqrTotal[$zhongxinModel->o_id]+$SMylqTotal[$zhongxinModel->o_id]+$SMblqTotal[$zhongxinModel->o_id]?></td>
        </tr>
    <tr  class="info-center hide bmtr bmp<?=$zhongxinModel->o_id?>">
            <td colspan="7">&nbsp;</td>
          
    </tr>
    <?php }?>
<?php   } ?>

        <tr >
            <td><b>合计:</b>&nbsp;(录入：<span class='ycolor'><?=$shenheTotal["all"]+$luquTotal["all"]+$bohuiTotal["all"]+$SMdqrTotal["all"]+$SMylqTotal["all"]+$SMblqTotal["all"]?></span>&nbsp;(录取：<span class='ycolor'><?=$SMylqTotal["all"]?>)</span></td>
            <td><?=$shenheTotal["all"]?>&nbsp;/&nbsp;<?=$shenheTotal["all"]+$luquTotal["all"]+$bohuiTotal["all"]?></td>
            <td><?=$luquTotal["all"]?>&nbsp;/&nbsp;<?=$shenheTotal["all"]+$luquTotal["all"]+$bohuiTotal["all"]?></td>
            <td><?=$bohuiTotal["all"]?>&nbsp;/&nbsp;<?=$shenheTotal["all"]+$luquTotal["all"]+$bohuiTotal["all"]?></td>
            <td><?=$SMdqrTotal["all"]?>&nbsp;/&nbsp;<?=$SMdqrTotal["all"]+$SMylqTotal["all"]+$SMblqTotal["all"]?></td>
            <td><?=$SMylqTotal["all"]?>&nbsp;/&nbsp;<?=$SMdqrTotal["all"]+$SMylqTotal["all"]+$SMblqTotal["all"]?></td>
            <td><?=$SMblqTotal["all"]?>&nbsp;/&nbsp;<?=$SMdqrTotal["all"]+$SMylqTotal["all"]+$SMblqTotal["all"]?></td>
        </tr>
    </tbody>
</table>

</div>
<script>
$(document).ready(function(){
    $("tr.btnshow").click(function(){
        if($(this).attr("attr")){
             $("."+$(this).attr("attr")).toggle();
            // if($(this).html()=="+"){
                // $(this).html("-")
            // }else{
                // $(this).html("+")
            // }
        }
        
    })
})
</script>