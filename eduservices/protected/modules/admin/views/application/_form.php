<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.validity/jquery.validate.js",CClientScript::POS_END);
// echo "<pre>";
// print_r($model->attributes);
?>
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/layout.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/zoomimage.css" />
<link rel="stylesheet" media="screen" type="text/css" href="/js/zoomimage.jquery/css/custom.css" />
<script type="text/javascript" src="/js/zoomimage.jquery/js/jquery.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/eye.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/utils.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/zoomimage.js"></script>
<script type="text/javascript" src="/js/zoomimage.jquery/js/layout.js"></script>
<div>
    <div class="form-horizontal userform">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <p class="pull-left lineh30 margin0  marl10 " >
                            <?php 
                                $usermodel=User::model()->findByPk($stuModel->s_addid);
                                $Omodel=Organization::model()->findByPk($usermodel->user_organization);
                                $OName=$Omodel->o_name;
                                if($usermodel->user_role==1){
                                    $POmodel=Organization::model()->findByPk($Omodel->o_pid);
                                    $OName=$POmodel->o_name;
                                }
                            ?>
                            <b>录入编号：</b><span class='blcolor1 '><?="{$stuModel->s_rpc}-{$OName}".str_pad($stuModel->s_insertid,6,0,STR_PAD_LEFT)?></span>
                            <b>录入员：</b>	
                            <span class="blcolor1"><?=User::model()->getUserName($stuModel->s_addid)?></span>
                            <span class='hcolor marl5'><?=date("Y-m-d H:i:s",$stuModel->s_addtime)?></span>
                            <b>录入批次：</b><span class='blcolor1 '><?=$stuModel->s_rpc?$stuModel->s_rpc:"未安排"?></span>
                            <b>排考批次：</b><span class='blcolor1 '><?=$stuModel->s_pc?$stuModel->s_pc:"未安排"?></span>
                            <b>审核状态：</b>
                            <span class="blcolor1"><?=@Students::$status[$stuModel->s_status]?></span>
                            <?php if(in_array($stuModel->s_status,array(2,3))){?>
                                <b class='marl5'>审核员：</b><span class="blcolor1"><?="华东监管中心{$stuModel->s_statusid}"//User::model()->getUserName($stuModel->s_statusid)?></span>
                                
                                <span class='hcolor marl5'><?=date("Y-m-d H:i:s",$stuModel->s_statustime)?></span>
                            <?php }?>
                        </p>
                        <div class="btn-group pull-right">
                            <a title="一栏显示" class="btn btnbg1"  href="javascript:showList(1,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"":"background:#ddd"?>'><i class="icon-align-justify"></i></a>
                            <a title="二栏显示"  class="btn btnbg2" href="javascript:showList(2,this)" style='<?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"background:#ddd":""?>'><i class=" icon-th-large"></i></a>
                            <a title="打印预览学生信息" class="btn" href="<?=Yii::app()->createUrl("admin/students/allprint",array("id"=>$stuModel->s_id))?>" target="_blank"><i class="icon-print"></i></a>	
                        </div>
                    </td>
                </tr>  
				<tr>
					<td>
						<div>
							<?php
								$form=$this->beginWidget('CActiveForm',array(
								'id'=>'application-form',
								"htmlOptions"=>array("enctype"=>"multipart/form-data"), //附件上传
								'enableAjaxValidation'=>false,
								));
							?>
							<div class="control-group">
								<label class="control-label" for="s_statusabout">申请类型 </label>
								<div class="controls">
									<p class="text"><?=Application::$type[$model->sa_type]?></p>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="s_statusabout">申请内容 </label>
								<div class="controls">
									<?php 
									if($model->isNewRecord||$model->sa_proposerid==Yii::app()->user->id||$stuModel->s_addid==Yii::app()->user->id){
										echo $form->textAREA($model,'sa_remarks',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"sa_remarks",'style'=>"width:400px;height:100px"));
									}else{
										echo "<p style='padding-top: 4px;'>".nl2br($model->sa_remarks)."</p>";
									}
									?>
									<p for="sa_remarks" class="error" style=""><?=isset($model->errors['sa_remarks'])?join('',$model->errors['sa_remarks']):""?></p>
								</div>
							</div>
                            
							<?/*<div class="control-group">
								<label class="control-label" for="s_statusabout">申请附件 </label>
								<div class="controls">
									<?php 
									if($model->isNewRecord||$model->sa_proposerid==Yii::app()->user->id||$stuModel->s_addid==Yii::app()->user->id){
										echo $form->fileField($model,'sa_fileurl',array('class'=>'input-large pull-left'));
									}
									echo !$model->isNewRecord?empty($model->sa_fileurl)?"<span class='pull-left' style='padding-top: 4px; color:red;'>无附件</span>":"<a class='pull-left' href='".$model->sa_fileurl."'>下载</a>":"";
									?>
									<p class="error  pull-left pl8">rar、zip的压缩文件!空为不变</p>
								</div>
							</div>*/?>
                            <div class="control-group">	
                                <label class="control-label" for="sa_fileurl">申请附件 </label>
                                <div class="controls">
                                    <div class="pull-left">
                                        <?php echo $form->textField($model,'sa_fileurl',array('readonly'=>'readonly','class'=>'input-large pull-left','maxlength'=>100,'name'=>"sa_fileurl")); ?>
                                        <a class="btn btn-mini btn-danger"  onclick="openUpload('sa_fileurl')">材料<?=!$model->sa_fileurl?"上传":"修改"?></a>
                                        <a class="btn btn-mini btn-success"  onclick="if($('#sa_fileurl').val()){　window.open ($('#sa_fileurl').val()) }else{alert('请先上传')}">查看</a>
                                    </div>
                                    <p for="sa_fileurl" class="error" style=""><?=isset($model->errors['sa_fileurl'])?join('',$model->errors['sa_fileurl']):""?></p>
                                    <p class=" pull-left pl8">材料格式必须为zip、rar、jpg、gif、png，且1M以下!</p>
                                </div>
                            </div>
							<?php if($model->sa_proposerid): ?>
							<div class="control-group">
								<label class="control-label" for="s_statusabout">申请操作人 </label>
								<div class="controls">
									<p class="text"><?=User::model()->getUserName($model->sa_proposerid)?></p>
								</div>
							</div>
							<?php endif; ?>
							<?php if(Yii::app()->user->role==4): ?>
							<div class="control-group">
								<label class="control-label" for="s_statusabout">审核状态<span class="rcolor">*</span> </label>
								<div class="controls">
									<div class='pull-left'>
									<label class="radio inline" style="width:60px;">
									<input type="radio" name="sa_status" id="sa_status_0" <?=$model->sa_status=="2"?"checked":""?> value="2">通过
									</label>
									<label class="radio inline" style="width:60px;">
									<input type="radio" name="sa_status" id="sa_status_1" <?=$model->sa_status=="1"?"checked":""?> value="1">待审核
									</label>
									</div>
									<p class="error  pull-left pl8">待审核后重审!</p>
									<p for="sa_status" htmlfor='sa_status' class="error" style=""><?=isset($model->errors['sa_status'])?join('',$model->errors['sa_status']):""?></p>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="s_statusabout">审核备注 </label>
								<div class="controls">
									<?php echo $form->textAREA($model,'sa_statusremarks',array('class'=>'input-large pull-left','maxlength'=>200,'name'=>"sa_statusremarks",'style'=>"width:400px;height:100px")); ?>
									<p class="error  pull-left pl8">监管中心才有此权限!</p>
									<p for="sa_statusremarks" class="error" style=""><?=isset($model->errors['sa_statusremarks'])?join('',$model->errors['sa_statusremarks']):""?></p>
								</div>
							</div>
							<?php endif; ?> 
							<div class="form-actions">
								<button type="submit" class="btn btn-primary"  name="addsubmit" value="add" onclick='unbindunbeforunload()' ><?=!$model->isNewRecord?$model->sa_shtime?"重新申请":"修改":"申请"?></button>&nbsp;
								<?php 
								if(isset($_GET['return'])&&$_GET['return']=='view'){
									$url=Yii::app()->createUrl("admin/application/view",array("id"=>$model->sa_id));
								}else{
									$url = isset($_COOKIE['xysqlistreturnurl'])?$_COOKIE['xysqlistreturnurl']:Yii::app()->createUrl("admin/application/index");
								} ?>
								<a href="<?=$url?>" class="btn btn-primary" >返回</a>
							</div>
							<?php $this->endWidget(); ?>
						</div>
					</td>
				</tr>                
                <tr>
                    <td class=" <?=isset($_COOKIE['showtype'])&&$_COOKIE['showtype']=='column'?"linebg":"nolinebg"?>" width="100%">
                         <?php 
                            $id=$stuModel->s_addid;
                            $user=User::model()->findByPk($id);
                            $checkArr=$user->user_bddm?explode(",",$user->user_bddm):array();
                            $sfcode=substr(strtolower(trim($stuModel->s_credentialsnumber)),0,2);
                            $valid=false;
                            if(in_array($sfcode,$checkArr)){
                                $valid = true;
                            }
                            
                            if($valid){
                                $CardDate=Students::model()->getIDCardInfo($stuModel->s_credentialsnumber);	
                                $SFCardNum=$stuModel->s_credentialsnumber;
                                if($stuModel->s_credentialstype==1&&$CardDate!=date("Ymd",$stuModel->s_birthdate)){
                                    $SFCardNum=str_replace($CardDate,"<span style='color:red;font-weight:bold'>{$CardDate}</span>",$stuModel->s_credentialsnumber);	
                                }
                            }else{
                                $SFCardNum="<span style='color:red;font-weight:bold'>{$stuModel->s_credentialsnumber}</span>";
                            }
                        ?>
                        <div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
                            <div>
                                <dl class="dl-horizontal">
                                    <dt>姓名</dt><dd><?=$stuModel->s_name?>&nbsp;</dd>
                                    <dt>性别</dt><dd><?=Students::$sex[$stuModel->s_sex]?>&nbsp;</dd>
                                    <dt>个人照片</dt><dd class="gr-photo"><a class="bwGal" title="个人照片" rel="gal" target='_blank' href='<?=$stuModel->s_headerimg?>'><img src="<?=$stuModel->s_headerimg?>" /></a>&nbsp;</dd>
                                    <dt>证件号码</dt><dd><?=Students::$credentialstype[$stuModel->s_credentialstype]."：".$SFCardNum?>&nbsp;</dd>
                                    <dt>证件扫描件</dt><dd class="smj-photo">
                                        <a class="bwGal" title="身份证扫描件正面" rel="gal"  target='_blank' href='<?=$stuModel->s_credentialsimg1?>'><img src="<?=$stuModel->s_credentialsimg1?>" /></a>
                                        <a class="bwGal" title="身份证扫描件反面" rel="gal"  target='_blank' href='<?=$stuModel->s_credentialsimg2?>'><img src="<?=$stuModel->s_credentialsimg2?>	" /></a>
                                    &nbsp;</dd>
                                    <dt>出生日期</dt><dd><?=date("Ymd",$stuModel->s_birthdate)?>&nbsp;</dd>
                                    <dt>出生地</dt><dd><?=$stuModel->s_birthaddress?>&nbsp;</dd>
                                    <dt>民族</dt><dd><?=Lookup::model()->getValueName($stuModel->s_nationality,"nationality")?>&nbsp;</dd>
                                    <dt>政治面貌</dt><dd><?=Lookup::model()->getValueName($stuModel->s_politicalstatus,"politicalstatus")?>&nbsp;</dd>
                                    <dt>最高学历</dt><dd><?=Students::$highesteducation[$stuModel->s_highesteducation]?>&nbsp;</dd>
                                    <dt>手机</dt><dd><?=$stuModel->s_phone?>&nbsp;</dd>
                                    <dt>邮箱</dt><dd><?=$stuModel->s_email?>&nbsp;</dd>
                                    <dt>报考层次</dt><dd><?=Lookup::model()->getValueName($stuModel->s_baokaocengci,"professionallevel")?>&nbsp;</dd>
                                    <dt>报考专业</dt><dd><?=Professional::model()->getZyName($stuModel->s_baokaozhuanye)?>&nbsp;</dd>
                                    <dt>职业状况</dt><dd><?=Students::$profession[$stuModel->s_zhiyezhuangkuang]?>&nbsp;</dd>
                                    <dt>婚姻状况</dt><dd><?=Students::$marital[$stuModel->s_hunyinzhuangkuang]?>&nbsp;</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="<?=isset($_COOKIE['showtype'])?$_COOKIE['showtype']:"nocolumn"?>">
                            <div>
                                <dl class="dl-horizontal">
                                    <dt>家庭地址</dt><dd><?=$stuModel->s_familyaddress?$stuModel->s_familyaddress:"&nbsp;"?>&nbsp;</dd>
                                    <dt>工作单位</dt><dd><?=$stuModel->s_gongzuodanwei?$stuModel->s_gongzuodanwei:"&nbsp;"?>&nbsp;</dd>
                                    <dt>邮编</dt><dd><?=$stuModel->s_youbian?$stuModel->s_youbian:"&nbsp;"?>&nbsp;</dd>
                                    <dt>通讯地址</dt><dd><?=$stuModel->s_contactaddress?$stuModel->s_contactaddress:"&nbsp;"?>&nbsp;</dd>
                                    <dt>联系电话</dt><dd><?=$stuModel->s_tel?$stuModel->s_tel:"&nbsp;"?>&nbsp;</dd>
                                    <dt>生源地</dt><dd><?=Lookup::model()->getValueName($stuModel->s_sfromaddress,"studentsfrom")?>&nbsp;</dd>
                                    <dt>生源状况</dt><dd><?=Lookup::model()->getValueName($stuModel->s_sfromtype,"studentsfromstatus")?>&nbsp;</dd>
                                    <dt>参加工作时间</dt><dd><?=date("Y-m",$stuModel->s_cjgztime)?>&nbsp;</dd>
                                    <?php if(in_array($stuModel->s_highesteducation,array(2,3,4,5))){?>
                                    <dt>原毕业院校</dt><dd><?=$stuModel->s_oldschool?>&nbsp;</dd>
                                    <dt>原毕业院校代码</dt><dd><?=$stuModel->s_oldschoolcode?$stuModel->s_oldschoolcode:"&nbsp;"?>&nbsp;</dd>
                                    <dt>原毕业专业</dt><dd><?=$stuModel->s_oldzhuanye?>&nbsp;</dd>
                                    <dt>原毕业时间</dt><dd><?=date("Y-m",$stuModel->s_oldtime)?>&nbsp;</dd>
                                    <?php }?>
                                    <dt>原毕业证书编号</dt><dd><?=$stuModel->s_oldimgnumber?>&nbsp;</dd>
                                    
                                    <dt>原毕业证书扫描件</dt><dd class="smj-photo">
                                
                                    <a  class="bwGal" title="原毕业证书扫描件" rel="gal"  target='_blank' href='<?=$stuModel->s_oldimg?>'><img src="<?=$stuModel->s_oldimg?>	" /></a>
                                    &nbsp;</dd>
                                    <?php if(in_array($stuModel->s_baokaocengci,array(2))){?>
                                    <dt>专升本证明</dt><dd class="smj-photo">
                                    <a class="bwGal" title="专升本证明" rel="gal" target='_blank' href='<?=$stuModel->s_zsbzm?>'><img src="<?=$stuModel->s_zsbzm?>	" /></a>&nbsp;</dd>
                                    <?php }?>
                                    <dt>入学方式</dt><dd><?=Students::$enrollment[$stuModel->s_enrollment]?>&nbsp;</dd>
                                    <dt>学习类型</dt><dd><?=Students::$study[$stuModel->s_study]?>&nbsp;</dd>
                                    <dt>其他证明材料</dt><dd><a target='_blank' href='<?=$stuModel->s_file?>'><?=$stuModel->s_file?></a>&nbsp;</dd>
                                    <dt>生源类型</dt><dd><?=Students::$bdtype[$stuModel->s_idbd]?></a>&nbsp;</dd>
                                </dl>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php //echo $this->renderPartial('_form', array('model'=>$model,'stuModel'=>$stuModel)); ?>

<script>
jQuery(document).ready(function(){
    jQuery("#application-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
				sa_remarks: { 
					required: true,
                    maxlength:200
				},
            },
            messages: {
				sa_remarks:{ 
					required: '请输入备注内容',
                    maxlength:'不得超过200个字'
				},
            }
            
        });
})
</script>
            </tbody>
        </table>
    </div>
</div>




































<script>
jQuery(document).ready(function(){
    jQuery("#application-form").validate({
            // debug: true,
			autoCreateRanges:true	,
            errorClass: "error",
            errorElement: "p",
            rules: {
				sa_remarks: { 
					required: true,
                    maxlength:200
				},
            },
            messages: {
				sa_remarks:{ 
					required: '请输入备注内容',
                    maxlength:'不得超过200个字'
				},
            }
        });
})
</script>