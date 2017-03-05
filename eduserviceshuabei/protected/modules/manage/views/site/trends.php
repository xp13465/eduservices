<?php
$this->pageTitle=Yii::app()->name . ' - 上传房价分析图';
$this->breadcrumbs=array(
	'上传房价分析图',
);
$this->currentMenu = 90;
?>
<style type="text/css">
    div.form label {
    display: inline;
}
</style>
<script type="text/javascript" src="<?=Yii::app()->request->baseUrl;?>/js/overlay.min.js"></script>
<h1>上传房价分析图</h1>

<div class="form">
    <form action="" method="post" enctype="multipart/form-data" onSubmit="return checkFrom()">
            <table width="100%" border="0" cellpadding="5" cellspacing="5" class="manage_tabletwo" style="margin-top:20px">
                <tr>
                    <td>
                        楼盘性质:<font color="red">可多选</font><br />
                    <?php echo CHtml::checkBoxList('buidtype','',array('1'=>'写字楼主页','2'=>'商铺主页','3'=>'住宅主页'));?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="file" name="trends" /> <font color="red">请上传大小为241&times;159,格式为gif图片</font>
                    </td>
                </tr>
            </table>
            <div style="float:right;margin-right: 55px ">
                <?php echo CHtml::submitButton('上 传',array('name'=>'submit')); ?>
            </div>
        </form>
</div>
<script type="text/javascript">
    function checkFrom(){
        if($(":checkbox[checked]").length === 0){
            alert('请选择分析图的所有者');
            return false;
        }
        var file = $(":file").val();
        if(file==""){
            alert('请选择上传图片');
            return false;
        }else if( ! /\.gif$/i.test(file) ){
            alert("请上传gif格式图片");
            return false;

        }
        return true;
    }
</script>