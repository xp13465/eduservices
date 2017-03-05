<form id="explodeExcel" action='<?=Yii::app()->createUrl("admin/emapp/outemapp",array())?>' target="_blank" method="post">

    <table width="500px">
        <tr style="line-height: 35px;">
            <td align="right" width="120px">证件类型：</td>
            <td align="left" >				
                <?php                
                    echo CHtml::dropDownList('mk_cardtype','', Emapp::$credentialstype,
                    array(
                    'class'=>"wauto",
                    'empty'=>'证件类型',
                    ));      
				?>
            </td>
        </tr>
    
       
        <tr style="line-height: 35px;">
            <td align="right" >免考科目选择：</td>
            <td align="left">
               <?php
                    echo CHtml::dropDownList('mk_subject','', Emapp::$subject,
                    array(
                    'name'=>'mk_subject',
                    'empty'=>'请选择免考科目',
                    'class'=>"wauto",
                    ));
				?>
            </td>
        </tr>
        
        <tr>
            <td align="right" >审核状态选择：</td>
            <td align="left">
                <?php 
				echo CHtml::dropDownList('mk_status','', Emapp::$status, 
				array(
				'class'=>"wauto",
				'empty'=>'审核状态',
				));
				?>
            </td>
        </tr>
       
    </table>
</form>
<script>
function createAlbum(){
           var content = "<div id='alertform'>"+$("#albumform").html()+"</div>";
            jw.pop.customtip(
            "导出数据-默认导出全部",
            content,
            {
                hasBtn_ok:true,
                hasBtn_cancel:true,
                zIndex:10000,
                ok: function(){
                   
					$("#alertform form").submit();
					// mark._hide()
					return false;
                    
                },
                btn_float:"center"
            }
        );
    }
</script>
