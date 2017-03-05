<?php
/* @var $this ExampaperController */
/* @var $dataProvider CActiveDataProvider */
$Arrays=$dataProvider->getData();
$this->breadcrumbs=array(
	'Exampapers',
);

$this->menu=array(
	array('label'=>'Create Exampaper', 'url'=>array('create')),
	array('label'=>'Manage Exampaper', 'url'=>array('admin')),
);
?>
<link rel="stylesheet" href="/css/student/student-exam.css">

<div class="exam-box">
	<div class="search">
		<p class="lfloat">
			每页显示
			<select onchange="setpagesize('sj_pagesize',this.value)">
				<option value='10' <?php if(isset($_COOKIE['sj_pagesize'])&&$_COOKIE['sj_pagesize']==10)echo "selected";?>>10</option>
				<option value='20' <?php if(isset($_COOKIE['sj_pagesize'])&&$_COOKIE['sj_pagesize']==20)echo "selected";?>>20</option>
				<option value='30' <?php if(isset($_COOKIE['sj_pagesize'])&&$_COOKIE['sj_pagesize']==30)echo "selected";?>>30</option>
				<option value='50' <?php if(isset($_COOKIE['sj_pagesize'])&&$_COOKIE['sj_pagesize']==50)echo "selected";?>>50</option>
			</select>
			条
		</p>
        <?php /*
        <form class="margin0" action="" id="sqform" name="sqform">
            <p class="rfloat">搜索：<input type="text" name="ename" value="<?=isset($_GET['ename'])&&$_GET['ename']?$_GET['ename']:""?>" onkeydown='if(event.keyCode=="13"){document.getElementById("sqform").submit();}' /></p>
        </form>
        */ ?>
	</div>
	<div class="exam-list">
		<table class="table table-list">
			<thead>
				<tr align="center">
					<td width="6%">序号</td>
                    <td width="8%">场次</td>
					<td width="32%">试卷名称</td>
					<td width="12%">开始时间</span></td>
					<td width="12%">终止时间</td>
					<td width="12%">考试时长</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
				 <?php
                 // $this->widget('zii.widgets.CListView', array(
                        // 'dataProvider'=>$dataProvider,
                        // 'template'=>'{items}',
                        // 'itemView'=>'_view',                        
                    // )); 
                   // print_r($dataProvider);
                   

                // $this->render('_view',array(
                // 'dataProvider'=>$Arrays,
                // ));
                
                    foreach($Arrays as $k=>$row){
                     // echo $row->ea_examid;
                        if($row->ea_examid){                         
                            $exmodel=Exampaper::model()->findByPk($row->ea_examid);
                            $this->renderPartial('_view',array("k"=>$k,"val"=>$row,'exmodel'=>$exmodel));
                        }else{
                            $criteria = new CDbCriteria;
                            $zyModel=Professional::model()->findByPk($Smodel->s_baokaozhuanye);
                            $criteria->addCondition("e_cc ='{$Smodel->s_baokaocengci}' or e_cc=0");
                            if($zyModel){
                                $criteria->addCondition("e_ktype ='{$zyModel->p_type}' or e_ktype=0");
                            }
                            $criteria->addCondition("e_btime<=".time());        
                            $criteria->addCondition("e_etime>=".time());  
                            $criteria->addCondition("e_use = 1 and e_isdel = 1"); 
                            $models=Exampaper::model()->findAll($criteria);
                            foreach($models as $examkey=>$data){
                                $this->renderPartial('_view',array("k"=>$k,"val"=>$row,'exmodel'=>$data));
                                    $k++;
                           }
                        }
                    }
                    ?>
			</tbody>
		</table>
	</div>
	<div class="exam-fy">
		<p class="lfloat">第<span class="blue"><?=$dataProvider->pagination->currentPage+1?></span>页，共<span class="blue"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页。每页<span class="blue"><?=isset($_COOKIE['sj_pagesize'])?$_COOKIE['sj_pagesize']:"1";?></span>条，共<span class="blue"><?=$dataProvider->pagination->itemCount?></span>条。</p>
		
        <?php 	$this->widget('CStudentlinkPager',array(
                    'pages'=>$dataProvider->pagination,
                ));?>
		
          
                        
</div>