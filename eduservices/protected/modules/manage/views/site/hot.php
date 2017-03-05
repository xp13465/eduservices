<?php
$this->currentMenu =isset($_GET['m'])?$_GET['m']:'';
$this->breadcrumbs=array(
	'楼盘发布房源数排名',
    $typeName,
);

$this->menu=array(
	array('label'=>'写字楼', 'url'=>array('hot','t'=>'office')),
    array('label'=>'　租', 'url'=>array('hot','t'=>'office','sr'=>'rent')),
    array('label'=>'　售', 'url'=>array('hot','t'=>'office','sr'=>'sell')),
    //array('label'=>'商　铺', 'url'=>array('hot','t'=>'shop')),
    array('label'=>'住　宅', 'url'=>array('hot','t'=>'zhuzhai')),
    array('label'=>'　租', 'url'=>array('hot','t'=>'zhuzhai','sr'=>'rent')),
    array('label'=>'　售', 'url'=>array('hot','t'=>'zhuzhai','sr'=>'sell')),
);
?>
<style type="text/css">
.table-data,.table-data th,.table-data td {
    border:1px solid #FFFFFF;
    border-collapse:collapse;
}
</style>
<?php
echo CHtml::dropDownList('region',$greg,$regions,array('onchange'=>'gotoURL(this.value)','empty'=>'请选区域'));
?>
<h1>楼盘发布房源数排名—<?=$typeName?>(<font style="color: red;">上海 <?=$greg?$regions[$greg]:''?></font>)</h1>

<table class="table-data">
    <tr bgcolor="#D3DCE3">
        <th>NO.</th>
        <th>发布房源数量（<?php if($sr=='rent')echo'租';elseif($sr=='sell')echo'售';else echo '租售'; ?>）</th>
        <th>大厦名称</th>
    </tr>
<?php
foreach($hots as $key=>$hot){
?>
    <tr bgcolor="<?=$key&1?'#E5E5E5':'#D5D5D5'?>">
        <td>NO.<?php echo $summary['{start}']+$key+1; ?></td>
        <td><?php echo $hot['c']; ?></td>
        <td><?php echo $hot['name'],CHtml::link('查看',MAINHOST.Yii::app()->createUrl($t=='office'?'systembuildinginfo/view':'communitybaseinfo/view',array("id"=>$hot['sysid'])),array("target"=>"_blank"));?></td>
    </tr>
<?php } ?>
</table>

<div class="pager">
    <?php $this->widget('CLinkPager',$pages); ?>
</div>
<script type="text/javascript">
function gotoURL(region){
    var url=location.href;
    if(url.indexOf('greg=')!=-1){
        location.href=location.href.replace(/=\d*/,'='+region);
    }else{
        location.href=location.href+'?greg='+region;
    }
}
</script>
<?php 
/*
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
 * ?>
 */