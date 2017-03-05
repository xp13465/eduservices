<?php
/* @var $this StudentsController */
/* @var $model Students */

//if(isset($_GET['type'])&&in_array($_GET['type'],array(1,2,"other"))){
    $this->breadcrumbs=array(
        '学员管理',
        '学员添加',
    );

    $this->menu=array(
        // array('label'=>'List Students', 'url'=>array('index')),
        // array('label'=>'Manage Students', 'url'=>array('admin')),
    );
     
    echo $this->renderPartial('_form', array('model'=>$model)); /* 
}else{ ?>
<div style="margin:10px 0 10px;; marheight:200px;width:590px;">
 	<div class="click-ico">
		<a href='<?=Yii::app()->createUrl("admin/students/add",array("type"=>"1"))?>' >
			<img src="/images/ss.png" title="神思读卡器身份证录入" />
			神思读卡器身份证录入
		</a>
	</div> 
	<div class="click-ico">
		<a href='<?=Yii::app()->createUrl("admin/students/add",array("type"=>"2"))?>' >
			<img src="/images/gt.png"  title="国腾读卡器身份证录入" />
			国腾读卡器身份证录入
		</a>
	</div> 
	<div class="click-ico">
		<a href='<?=Yii::app()->createUrl("admin/students/add",array("type"=>"other"))?>' >
			<img src="/images/qt.png"  title="其他证件手动录入" />
			其他证件手动录入
		</a>
	</div> 
 </div>
<?php }*/?>
