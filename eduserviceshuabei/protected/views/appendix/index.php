<?php $model=$dataProvider->getData();?>
<div class="cleaner_h5"></div>
		<?php $this->renderPartial("/news/_leftMenu")?>


<div class="main mainContent">
	<div class="infolist_title"><b>当前位置：<a class="xa" href="<?php echo Yii::app()->createUrl("appendix/index")?>" target="_self" >资料下载</a></b></div>
	<div class="cleaner_h5"></div>
<div class="mainNews">
    <?php foreach($model as $file){?>
	<div class="CategoryInfos" style="border-bottom: 1px dotted #cccccc;">
		<span class="newsdate"><?=date("(Y-m-d)",$file->createtime)?>   </span><span class="pillar"></span>
		<span class="news" title="<?=$file->name?>" style="width:700px;*width:400px;_width:400px;display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;float:left;*float:none; ">
			<img src="/images/sublist.gif">
			<span class="pillar"></span>
			<img src="/images/new.gif" border="0">&nbsp;
			<a href="<?php echo Yii::app()->createUrl("/appendix/detail",array("id"=>$file->id))?>" style="color:#000000" ><?=$file->name?></a>
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
