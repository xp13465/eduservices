<!--左边列开始-->
<div class="navLeft navLeftContent">
	<div class="webpart">
		<h1><span class="pillar"></span>网院快讯</h1>
		<div class="webpart_nav">
			<ul>
                <?php foreach(Information::$class as $key=>$val){ 
                    if(!in_array($key,array(1,2,3,4)))continue;
                ?>
				<li style=" border:0px solid red; ">
					<span class="pillar"></span>
					<img src="/images/LastPhoto_l1.gif" align="absmiddle">
					<a href="<?=Yii::app()->createUrl("news/index",array('id'=>$key))?>"><?=$val?></a>
				</li>
                <?php }?>
			</ul>
		</div>
	</div>
</div>
<!--左边列结束-->
