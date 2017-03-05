<?php
    $this->breadcrumbs=array(
        '考试管理'=>array('index'),
        '手工阅卷',
    );
    $url=isset($_COOKIE['ksgllistreturnurl'])?$_COOKIE['ksgllistreturnurl']:array("index");
    $this->menu=array(
        array('label'=>'返回考试管理列表', 'url'=>$url),
    );

?>
<div class="clear">
<div class="controls" style="text-align:center;">
	<label style="font-size:25px; font-weight:bold;">试卷名称：<?php echo $examModel->e_name?></label>
	<label style="font-family:微软雅黑;font-size:13px;font-weight:normal;font-style:normal;text-decoration:none;">成绩： <?php echo $model->sc_kgmark + $model->sc_zgmark?>分</label>
</div>
<?php
    echo $this->renderPartial('_form',array('model'=>$model,'examModel'=>$examModel,));
?>
</div>