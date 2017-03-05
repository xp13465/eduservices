<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);

$this->breadcrumbs=array(
	'学校信息设置'=>array("professional/index"),
	'专业管理',
);

// $this->menu=array(
	// array('label'=>'Create Organization', 'url'=>array('create')),
	// array('label'=>'Manage Organization', 'url'=>array('admin')),
// );
$show='';
$type='';
?>

<?php $Arrays=$dataProvider->getData();?>
<div class="show-grid">
	<div class="span8">
		<div class="clear">
			<form action="">
				<span>搜索：</span>
				
				<?php 
						$iscenci=isset($_GET['p_pid'])?$_GET['p_pid']:"";
						echo CHtml::DropDownList('p_pid',$iscenci,Lookup::model()->getClassInfo('professionallevel'), array(
							"name"=>"p_pid",
							'empty'=>'请选择专业层次'));
						
				
				?>
				<input class="wauto" type="text" name='p_name' onfocus='checkifocus("专业名称..",this)' onblur='checkiout("专业名称..",this)' value="<?=isset($_GET['p_name'])?$_GET['p_name']:"专业名称.."?>">
				<?php /*<input class="wauto" type="text" name='s_name' onfocus='checkifocus("<?=$show?>代码..",this)' onblur='checkiout("<?=$show?>代码..",this)' value="<?=$show?>代码..">*/?>
				<button type="submit" class="btn btn-inverse serach">搜索</button>
			</form>
		</div>
		<div>
			<table class="table table-bordered specialtylist">
				<?php 
					$get=$_GET;
					if(isset($_GET['order'])&&in_array($_GET['order'],array("ku","kd"))){
						$tmp=$_GET['order']=="ku"?"↑":"↓";
						$get['order']=$_GET['order']=="ku"?"kd":"";
						$tmpUrl=Yii::app()->createUrl("admin/professional/index",$get);
					}else{
						$tmp="↑↓";
						$get['order']="ku";
						$tmpUrl=Yii::app()->createUrl("admin/professional/index",$get);
					}?>
				<thead>
					<tr>
					<th width="4%"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
					<th width="80px">层次代码</th>
					<th width="90px">所属层次 <a class="order" href="<?=$tmpUrl?>"><?=$tmp?></a></th>
					<th width="110px">专业代码</th>
					<th >专业名称</th>
                    <th width="70px">类型</th>
                    <th width="70px">状态</th>
					<th width="120px">操作</th>
					</tr>
					</thead>
				<tbody>
				<?php 	if(!$Arrays){?>
							<tr>
							<td colspan='11'>没有找到数据</td>
							</tr>
				<?php 	}else{
							foreach($Arrays as $key=>$data){
                                if($this->beginCache("professional_view_{$key}", array('duration'=>0))) {
                                        $this->renderPartial('_view',array("data"=>$data,"key"=>$key));
                                $this->endCache(); }
							}
						}?>
				</tbody>
			</table>
		</div>
		<div class="clear ohidden">
			<p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<!-- <a class="btn btn-primary" href="#"><i class="icon-edit icon-white"></i> 编辑</a> -->
				<a class="btn btn-danger" href="javascript:GetCheckbox('professional')"><i class="icon-trash icon-white"></i> 删除</a>
				<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
			</p>
			<p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("p_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['p_pagesize'])?$_COOKIE['p_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("p_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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
	<div class="span4">
		<h2>添加新专业</h2>
		<div class="ohidden well">
			<form class="form-horizontal" id='professionalForm' action="" method="post">
			
						<p>
							<label class="weight">所属层次</label>
							 <?php echo CHtml::DropDownList('p_pid',$newmodel->p_pid, Lookup::model()->getClassInfo('professionallevel'), array(
							"name"=>"p_pid",
							'empty'=>'请选择专业层次',
							'class'=>"pull-left")); ?>
							<span for="p_pid" class="error" style=""><?=isset($newmodel->errors['p_pid'])?join('',$newmodel->errors['p_pid']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
                        <p>
							<label class="weight">专业类型</label>
							 <?php echo CHtml::DropDownList('p_type',$newmodel->p_type, Professional::$type, array(
							"name"=>"p_type",
							'empty'=>'请选择专业类型',
							'class'=>"pull-left")); ?>
							<span for="p_type" class="error" style=""><?=isset($newmodel->errors['p_type'])?join('',$newmodel->errors['p_type']):""?></span>
							<span class="help-inline rcolor"></span>
						</p></br>
						<p>
							<label class="weight">专业名称</label>
							<input type="text" name='p_name' value="">
							<span for="p_name" class="error" style=""><?=isset($newmodel->errors['p_name'])?join('',$newmodel->errors['p_name']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
						<p>
							<label class="weight">专业代码</label>
							<input type="text" name='p_code' value="">
							<span for="p_code" class="error" style=""><?=isset($newmodel->errors['p_code'])?join('',$newmodel->errors['p_code']):""?></span>
							<span class="help-inline rcolor"></span>
						</p>
		
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
			$("#professionalForm").validate({
				// debug: true,
				autoCreateRanges:true	,
				errorClass: "error",
				errorElement: "span",
				rules: {
					p_pid: 'required',
					p_name:'required',
					p_code:'required'	
				},
				messages: {
					p_pid:'请选择专业层次',
					p_name:'请输入专业名称',
					p_code:'请输入专业代码'
				}
			});
		
		})
		</script>
	</div>
</div>
			

