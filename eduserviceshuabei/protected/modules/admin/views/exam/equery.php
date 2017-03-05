<!--/span-->
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
$this->pageTitle = "成绩查询-" .$this->pageTitle;
$this->breadcrumbs=array(
	'入学考试管理'=>array("equery"),
	'成绩查询'
);

// $this->menu=array(
	// array('label'=>'Create Organization', 'url'=>array('create')),
	// array('label'=>'Manage Organization', 'url'=>array('admin')),
// );
 $Arrays=$dataProvider->getData();
?>
                 <div class="clear">
                 
    <form action=""   onsubmit="return checkSearch(this,'<?=Yii::app()->createUrl("admin/exam/equery")?>')">
           搜索：
             角色：
        <?php 
        $pctmp=isset($_GET['s_pc'])?$_GET['s_pc']:"";
		echo CHtml::dropDownList('s_pc',$pctmp, array('s_pc'=>"入学测验",'s_pc'=>'管理员','s_pc'=>'用户'),
		array(
		'class'=>"wauto",
		'empty'=>'全部',
		));
        ?>
            排考场次：<input class="wauto" size='10px' type="text" name="stpkcc" onfocus='checkifocus("排考场次...",this)' onblur='checkiout("排考场次...",this)' value="<?=isset($_GET['stpkcc'])&&$_GET['stpkcc']?$_GET['stpkcc']:"排考场次..."?>">
            姓名：<input class="wauto" type="text" name="stname" onfocus='checkifocus("姓名...",this)' onblur='checkiout("姓名...",this)' value="<?=isset($_GET['stname'])&&$_GET['stname']?$_GET['stname']:"姓名..."?>">
            身份证：<input class="wauto" type="text" name="stsfz"  onfocus='checkifocus("身份证...",this)' onblur='checkiout("身份证...",this)' value="<?=isset($_GET['stsfz'])&&$_GET['stsfz']?$_GET['stsfz']:"身份证..."?>">
            试卷名称：<input class="wauto" type="text" name="exename" onfocus='checkifocus("关键字...",this)' onblur='checkiout("关键字...",this)' value="<?=isset($_GET['exename'])&&$_GET['exename']?$_GET['exename']:"关键字..."?>">
             <button class="btn btn-inverse serach" type="submit">搜素</button>
	</form>    
     
         </div>
         <table class="table table-bordered userlist">
             <thead>
                 <tr>
                     <th width="5%"><input type="checkbox" name="selectAll" id="selectAll" onclick="javascript:SelectAll('selectdel[]')" value=""></th>
                     <th width="5%"><b>ID / 考试场次</b></th>
                     <th width="7%"><b>姓名</b></th>
                     <th width="12%"><b>身份证</b></th>
                     <th width="23%"><b>试卷[<font color="#CC0000">总分数</font>]</b></th>
                     <th width="5%"><b>考试时间</b></th>
                     <th width="5%"><b>考试分数</b></th>
                     <th width="10%"><b>登陆方式</b></th>
                     <th width="15%">操作</th>
                 </tr>
             </thead>
             <tbody>
             
            <?php           
           if(!$Arrays){?>
							<tr><td colspan='10'>没有找到数据</td></tr>
			<?php 	}else{
                        foreach($Arrays as $key=>$data){
                            $this->renderPartial('_equery',array("data"=>$data,"key"=>$key));
                        }
			}?>
            </tbody>
         </table>
         <div class="clear ohidden">             
            <p class="pull-left">
				<a class="btn btn-success" onclick="$('#selectAll').click();SelectAll('selectdel[]')" ><i class="icon-ok icon-white"></i> 全选</a>
				<?php /*if(Yii::app()->user->role==4){?>
                <a class="btn btn-danger" href="javascript:GetCheckbox('exam')"><i class="icon-trash icon-white"></i> 删除</a>
                <?php }*/?>
				<a class="btn" href="javascript:window.location.reload()"><i class="icon-refresh"></i> 刷新</a>
			</p>
             <p class="input-append pull-right">
				<input class="width60" id='pagesize' onkeydown='if(event.keyCode=="13"){setpagesize("e_pagesize",this.value)}' type="text" value="<?=isset($_COOKIE['e_pagesize'])?$_COOKIE['e_pagesize']:"20"?>">
				<button class="btn btn-info" type="button" onclick='setpagesize("e_pagesize",$("#pagesize").val())'>设置每页显示条数</button>
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
         
<?php /* 拷贝出来的导出内容*/?>
<div id="albumform" style="display:none ">
	<?=$this->renderPartial('_albumform');?>
</div>
<!--/span-->