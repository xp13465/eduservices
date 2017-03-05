<?php
/* @var $this ExamController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Scores',
);

$this->menu=array(
	array('label'=>'Create Score', 'url'=>array('create')),
	array('label'=>'Manage Score', 'url'=>array('admin')),
);
?>

<div class="exam-box">
	<div class="search">
		<p class="lfloat">
			每页显示
			<select onchange="setpagesize('cj_pagesize',this.value)">				
                <option value='10' <?php if(isset($_COOKIE['cj_pagesize'])&&$_COOKIE['cj_pagesize']==10)echo "selected";?>>10</option>
				<option value='20' <?php if(isset($_COOKIE['cj_pagesize'])&&$_COOKIE['cj_pagesize']==20)echo "selected";?>>20</option>
				<option value='30' <?php if(isset($_COOKIE['cj_pagesize'])&&$_COOKIE['cj_pagesize']==30)echo "selected";?>>30</option>
				<option value='50' <?php if(isset($_COOKIE['cj_pagesize'])&&$_COOKIE['cj_pagesize']==50)echo "selected";?>>50</option>
			</select>
			条
		</p>
        <form class="margin0" action="" id="cjform" name="cjform">
            <p class="rfloat">搜索：<input type="text" name="ename" value="<?=isset($_GET['ename'])&&$_GET['ename']?$_GET['ename']:""?>" onkeydown='if(event.keyCode=="13"){document.getElementById("cjform").submit();}' /></p>
        </form>
	</div>
	<div class="exam-list">
		<table class="table table-list">
			<thead>
				<tr align="center">
					<td width="18%">序号/排考场次</td>
					<td width="30%">试卷名称</td>
					<td width="40%">答题时间</span></td>
					<td>成绩</td>
				</tr>
			</thead>
			<tbody>
				<?php 
                    // foreach($dataProvider as $key=>$val){
                       // $this->renderPartial("_view",array('key'=>$key,'data'=>$val));
                    // }
                    ?>
                    <?php
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'template'=>'{items}',
                        'itemView'=>'_view',                        
                    )); ?>
			</tbody>
		</table>
	</div>
	<div class="exam-fy">
		<p class="lfloat">第<span class="blue"><?=$dataProvider->pagination->currentPage+1?></span>页，共<span class="blue"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页。每页<span class="blue"><?=isset($_COOKIE['cj_pagesize'])?$_COOKIE['cj_pagesize']:"1";?></span>条，共<span class="blue"><?=$dataProvider->pagination->itemCount?></span>条。</p>
		<?php 	$this->widget('CStudentlinkPager',array(
                    'pages'=>$dataProvider->pagination,
                ));?>
	</div>
</div>