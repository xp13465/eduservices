<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'题库集管理'=>array("Examset/index"),
	$show,
);

// $this->menu=array(
	// array('label'=>'Create Examset', 'url'=>array('create')),
	// array('label'=>'Manage Examset', 'url'=>array('admin')),
// );
?>
<?php $Arrays=$dataProvider->getData();?>
<div class="show-grid">
	<div class="span7">
		<div class="clear">
			<form action=""   onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/examset/index")?>')">
				<span>搜索：</span>	
                <?php 
                    if($show=='题库'){
                    $iszhongxin=isset($_GET['q_examset'])?$_GET['q_examset']:"";
						echo CHtml::DropDownList('q_examset',$iszhongxin,Questions::model()->getQrByPid(0), array(
							"name"=>"q_examset",
							'empty'=>'请选择题库集'));
                    }
                ?>
				<input class="wauto" type="text" name='q_name' onfocus='checkifocus("<?=$show?>名称..",this)' onblur='checkiout("<?=$show?>名称..",this)' value="<?=isset($_GET['q_name'])?$_GET['q_name']:$show."名称.."?>">
				<?php /*<input class="wauto" type="text" name='s_name' onfocus='checkifocus("<?=$show?>代码..",this)' onblur='checkiout("<?=$show?>代码..",this)' value="<?=$show?>代码..">*/?>
				<button type="submit" class="btn btn-inverse serach">搜索</button>
			</form>
		</div>
		<div>
			<table class="table table-bordered specialtylist">
				<thead>
					<tr>
						<?php 
						$get=$_GET;
						if(isset($_GET['order'])&&in_array($_GET['order'],array("ku","kd"))){
							$tmp=$_GET['order']=="ku"?"↑":"↓";
							$get['order']=$_GET['order']=="ku"?"kd":"";
							$tmpUrl=Yii::app()->createUrl("admin/examset/index",$get);
						}else{
							$tmp="↑↓";
							$get['order']="ku";
							$tmpUrl=Yii::app()->createUrl("admin/examset/index",$get);
						}?>
						<th width="2%"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
						<?php if($type=="second"){?>
						<th width="40%">题库集 </th>
						<th width="30%">题库名称<a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
						<?php }else{?>
						<th width="50%">题库集名称 <a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
						<?php }?>
						<th width="17%">操作</th>
					</tr>
				</thead>
				<tbody>
                    
				<?php 	
                if(!$Arrays){?>
							<tr>
							<td colspan='3'>没有找到数据</td>
							</tr>
				<?php 	}else{
							foreach($Arrays as $key=>$data){
								$view=$type?"_".$type:"_view";
								$this->renderPartial($view,array("data"=>$data,"key"=>$key));
							}
						}?>
				</tbody>
			</table>
		</div>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
				<a class="btn btn-danger" href="javascript:GetCheckbox('examset')"><i class="icon-trash icon-white"></i> 删除</a>
				<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("q_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['q_pagesize'])?$_COOKIE['q_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("q_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
			</p>
		</div>
		<div class="clear ohidden">
			<div class="pagination pull-left">
				<?php 	$this->widget('CBootstraplinkPager',array(
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
	<div class="span5">
		<h2>添加新<?=$show?></h2>
		<div class="ohidden well">
			<form class="form-horizontal" id='QuestionsForm' action="" method="post">
			<?php 	if($type=='second'){?>
						<p>
							<label class="weight">所属题库集</label>
							 <?php echo CHtml::DropDownList('q_pid','', Questions::model()->getQrByPid(0), array(
							"name"=>"q_pid",
							'empty'=>'请选择题库集',
							'class'=>"pull-left")); ?>
							<span for="q_pid" class="error" style=""><?=isset($newmodel->errors['q_pid'])?join('',$newmodel->errors['q_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p><br/>
						<p>
							<label class="weight"><?=$show?>名称</label>
							<input type="hidden" name='q_type' value="2">                            
							<input type="text" name='q_name' value="">
							<span for="q_name" class="error" style=""><?=isset($newmodel->errors['q_name'])?join('',$newmodel->errors['q_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
			<?php 	}else{?>
						<p>
							<label class="weight"><?=$show?>名称</label>
							<input type="hidden" name='q_pid' value="0">
							<input type="hidden" name='q_type' value="1">
							<input type="text" name='q_name' value="">
							<span for="q_name" class="error" style=""><?=isset($newmodel->errors['q_name'])?join('',$newmodel->errors['q_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
			<?php 	}?>
				<p>
				  <br/><button class="btn btn-primary" type="submit">添加数据</button>
				</p>
			</form>
		</div>
		<script>
		$(function(){
		<?php if(Yii::app()->user->hasFlash("message")){?>
		jw.pop.alert('<?=Yii::app()->user->getFlash("message")?>',{autoClose:2000})
		<?php }?>
			$("#QuestionsForm").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					<?php if($show=='题库'){?>
					q_pid:'required',
					<?php }?>
					q_name:'required',						
				},
				messages: {
					<?php if($show=='题库'){?>
					q_pid:'请选择题库集',
					<?php }?>
					q_name:'请输入<?=$show?>名称',
				}
			});
		
		})
		</script>
	</div>
</div>
			

