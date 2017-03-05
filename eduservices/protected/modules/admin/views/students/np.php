<?php 
$this->breadcrumbs=array(
	'学员管理'=>array("students/manage"),
	'北航学员管理导出',
);
$url=isset($_COOKIE['xylistreturnurl'])?$_COOKIE['xylistreturnurl']:array("manage");
$this->menu=array(
    array('label'=>'返回学员管理', 'url'=>$url),
);
?>
<div style='margin:10px auto;width:500px;border:0px solid #888;overflow:hidden'>
	<h1>北航学生入学资格信息导出</h1>
	
	<?php 	if(1==2){?>
		<a href="" style="float:right;margin:10px ">继续导出</a>
			<div id='listdiv' style='margin:10px auto;width:490px;height:400px;;border:1px solid #888;overflow:auto'>
			<?php 	?>			
			</div>
<?php	}else{?>
                    <div id="albumform" style="display:">
                        <?=$this->renderPartial('_albumform',array("type"=>"sm"));?>
                    </div>
                    <div  style="padding-top:2px;text-align:left  ">
                    <?php if(Yii::app()->user->role==4){?>
                    <a  class='btn btn-inverse' href='javascript:void()' onclick="cjexplode()">
                    <span>成绩导出</span>
                    </a>
                    <a  class='btn btn-inverse' href='javascript:void()' onclick="shdjexplode()">
                    <span>审核登记导出</span>
                    </a>
                    <?php }?>
                    <a  class='btn btn-inverse' href='javascript:void()' onclick="xyxxexplode()">
                    <span>学员信息导出</span>
                    </a>
                    </div>
<?php }?>
</div>
<script>
    <?php if(Yii::app()->user->role==4){?>
    function shdjexplode(){
        $("#albumform").find("#explodeExcel").attr("action","<?=Yii::app()->createUrl("admin/students/outstudentsmanage",array("type"=>"1"))?>")
        checkform();
    }
    function cjexplode(){
        $("#albumform").find("#explodeExcel").attr("action","<?=Yii::app()->createUrl("admin/students/outstudentsmanage",array("type"=>"2"))?>")
        checkform();
    }
    <?php }?>
    function xyxxexplode(){
        $("#albumform").find("#explodeExcel").attr("action","<?=Yii::app()->createUrl("admin/students/outstudentsmanage",array("type"=>"3"))?>")
        checkform();
    }
    function checkform(){
        $("#albumform").find("#explodeExcel").submit();
    }
</script>
