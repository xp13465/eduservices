<?php 
// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$this->breadcrumbs=array(
	'入学考试管理'=>array("questions/index"),
	'题库管理',
);
// $url=isset($_COOKIE['xylistreturnurl'])?$_COOKIE['xylistreturnurl']:array("index");
// $this->menu=array(
	// array('label'=>'返回学员列表', 'url'=>$url),
	// array('label'=>'编辑', 'url'=>array("students/edit","id"=>'#',"return"=>'view')),
// );
 $TpoicList=$dataProvider->getData();
?>
<div class="show-grid">
	<div class="span2 breadcrumb">
		<ul class="nav nav-list"> 
                        <li class="nav-header"><a href="<?=Yii::app()->createUrl("admin/questions/index/str")?>">所有题库集</a></li>
                        <li class="divider"></li>                                                    
                        <?php 
                        foreach($qmodel as $k=>$v){
                               if($v->q_type==1){
                                        $ca = new CDbCriteria;
                                        $ca->addCondition("q_pid='{$v->q_id}' and q_type=2 and q_isdel=1");
                                        $camodel=Questions::model()->findAll($ca);
                                       //print_r($camodel);
                                        $str="";
                                        foreach($camodel as $j=>$vv){
                                        // echo $j.count($camodel)."<br>";                                        
                                        $j+1==count($camodel)?$str=$str.$vv["q_id"]:$str=$str.$vv["q_id"].",";                                            
                                        }
                        ?>
                        
                             <li <?php echo isset($_GET['str'])&&$_GET['str']==$str?'class="active"':""?>>
                             <?php 
                             if($str==''){
                                echo $v->q_name;
                             }else{?>
                                <a href="<?=Yii::app()->createUrl("admin/questions/index",array('str'=>$str))?>"><?=$v->q_name?></a>
                             <?php }?>
                             
                             
                                        <?php                                                             
                                        $cirteria = new CDbCriteria;
                                        $cirteria->addCondition("q_pid='{$v->q_id}' and q_isdel=1");
                                        $qm=Questions::model()->findAll($cirteria);
                                        foreach($qm as $key=>$val){?>
                                        <ul class="nav sub-nav nav-list">
                                            <li <?php echo isset($_GET['t_qid'])&&$_GET['t_qid']==$val->q_id?'class="active"':""?> ><a href="<?=Yii::app()->createUrl("admin/questions/index",array("t_qid"=>$val->q_id))?>"><?=$val->q_name?></a></li>
                                        </ul>
                                        <?php }?>
                             </li>
                        <?php  }
                        } ?>                                                    
		</ul>
	</div>
	<div class="span10">
<form action="" id = "qform"   onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/questions/index")?>')">    
		<div class="clear">        
			题型：
            <?php 
						$iscenci=isset($_GET['t_type'])?$_GET['t_type']:"";
						echo CHtml::DropDownList('t_type',$iscenci,Topic::$type, array(
							"name"=>"t_type",
                            'class'=>'span1',
							'empty'=>'全部'));
			?>        
            
			难度：
            <?php 
						$iscenci=isset($_GET['t_level'])?$_GET['t_level']:"";
						echo CHtml::DropDownList('t_level',$iscenci,Topic::$level, array(
							"name"=>"t_level",
                            'class'=>'span1',
							'empty'=>'全部'));
			?>        
			分数：
            <input class="span2" type="text" name='t_score' onfocus='checkifocus("",this)' onblur='checkiout("",this)' value="<?=isset($_GET['t_score'])?$_GET['t_score']:""?>">
			题目内容：
            <input class="span2" type="text" name='t_con' onfocus='checkifocus("",this)' onblur='checkiout("",this)' value="<?=isset($_GET['t_con'])?$_GET['t_con']:""?>">
			知识点：
            <input class="span2" type="text" name='t_know' onfocus='checkifocus("",this)' onblur='checkiout("",this)' value="<?=isset($_GET['t_know'])?$_GET['t_know']:""?>">
            <input type = "hidden" name = "str" value = "<?=isset($_GET['str'])?$_GET['str']:""?>"/>
            <input type = "hidden" name = "t_qid" value = "<?=isset($_GET['t_qid'])?$_GET['t_qid']:""?>"/>
			<button class="btn btn-info serach" type="submit">查询</button>   
		</div>
</form>
		<div class="clear ohidden">
			<p class="pull-left">
                <?php $qid=isset($_GET['t_qid'])?$_GET['t_qid']:""?>
				<a class="btn btn-primary" href="<?=Yii::app()->createUrl("admin/questions/add",array("qid"=>$qid))?>"><i class="icon-plus icon-white"></i>新增试题</a>
                <?php
                /* 
				<a class="btn btn-inverse" href="<?=Yii::app()->createUrl("admin/questions/excellead")?>"><i class="icon-download-alt icon-white"></i>Execl导入</a>
				<a class="btn btn-info" href="<?=Yii::app()->createUrl("admin/questions/backups")?>"><i class="icon-share icon-white"></i>备份题库</a>
				<a class="btn btn-success" href="<?=Yii::app()->createUrl("admin/questions/restore")?>"><i class="icon-repeat icon-white"></i>还原题库</a>	
                */ ?>
			</p>
		</div>
		<table class="table table-bordered userlist">
			<thead>
				<tr>
					<th width="5%">
						<input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value="">
					</th>
                    <th width="5%">
						<b>ID</b>
					</th>
					<th width="10%">
						<b>题型</b>
					</th>
					<th width="10%">
						<b>知识点</b>
					</th>
					<th width="3%">
						<b>难度</b>
					</th>
					<th width="4%">
						<b>分数</b>
					</th>
					<th width="50%">
						<b>内容</b>
					</th>
					<th width="3%">
						<b>答案</b>
					</th>
					<th width="10%"><b>操作</b></th>
				</tr>
			</thead>
			<tbody>               
                <?php           
               if(!$TpoicList){?>
                                <tr><td colspan='11'>没有找到数据</td></tr>
                <?php 	}else{
                                foreach($TpoicList as $k=>$row){
                                    $this->renderPartial('_view',array("k"=>$k,"data"=>$row,'type'=>$type));
                                }
                }?>
			</tbody>
		</table>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
				<a class="btn btn-danger" href="javascript:GetCheckbox('questions')"><i class="icon-trash icon-white"></i> 删除</a>
                <a class="btn btn-info" target="_blank" href="<?=Yii::app()->createUrl('admin/questions/importq');?>"><i class="icon-arrow-up icon-white"></i> 导入</a>
				<a class="btn btn-warning" target = "_blank" href="<?=Yii::app()->createUrl('admin/questions/outq');?>" ><i class=" icon-share-alt icon-white"></i> 导出</a>
				<a class="btn" href="javascript:window.location.reload();"><i class="icon-refresh"></i> 刷新</a>
			</p>
			<p class="input-append pull-right">
                <input class="span3" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("t_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['t_pagesize'])?$_COOKIE['t_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("t_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
			</p>
		</div>
		<div class="clear ohidden">
			<div class="pagination pull-left">
				<ul>
				<li>
						<?php	$this->widget('CBootstraplinkPager',array(
										'pages'=>$dataProvider->pagination,
						));?>
				</li>
				</ul>
			</div>
			<div class="pagination pull-right">
                 当前第<span class="blcolor weight"><?=$dataProvider->pagination->currentPage+1?></span>页，共<span class="blcolor weight"><?=ceil($dataProvider->pagination->itemCount/$dataProvider->pagination->pageSize)?></span>页，共有<span class="blcolor weight"><?=$dataProvider->totalItemCount?></span>条数据。
             </div>
		</div>
	</div>
</div>