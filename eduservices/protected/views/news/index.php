<?php 
$Arrays=$dataProvider->getData();

?>
<div class="cleaner_h5"></div>
	<?php $this->renderPartial("_leftMenu")?>


<div class="main mainContent">
	<div class="infolist_title"><b>当前位置：</b><span id="ctl00_ctl00_ctl00_cphContent_cphContent_cphTitle_lblTitle"><?=array_key_exists($id,Information::$class)?Information::$class[$id]:''?></span></div>
	<div class="cleaner_h5"></div>
<div class="mainNews">
    <?php  foreach($Arrays as $key=>$data){?>
	<div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
        <span class="newsdate"><?=date("Y-m-d",$data->i_submitdate)?></span>
        <span class="pillar"></span>
        <span class="news" title="<?=$data->i_title?>" style="width:720px;*width:400px;_width:400px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
            <img src="/images/sublist.gif">
            <span class="pillar"></span>
            <a href="<?=Yii::app()->createUrl("news/detail",array('id'=>$data->i_id))?>" style="color:#36332F"><?=$data->i_title?></a>
        </span>
    </div>
	<div class="cleaner"></div>
    <?php }?>
	
	<div class="cleaner_h5"></div>
    <div class="clear ohidden">
        <div class="pagination pull-left">
        <?php 	$this->widget('CLinkPager',array(
                    'pages'=>$dataProvider->pagination,
                ));?>
        </div>
        <div class="pagination pull-right">
            当前第<span class="blcolor weight"><?=$dataProvider->pagination->currentPage+1?></span>页，
            共<span class="blcolor weight"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页，
            共有<span class="blcolor weight"><?=$dataProvider->pagination->itemCount?></span>条数据。
        </div>
    </div>

</div>
</div>

<div class="cleaner"></div>
