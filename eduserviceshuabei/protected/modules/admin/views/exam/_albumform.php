<form id="explodeExcel" action='<?=Yii::app()->createUrl("/admin/exam/outexcel");?>' target="_blank" method="post">

    <table width="500px">
        <tr style="line-height: 35px;">
            <td align="right" width="60px">条件1</td>
            <td align="left" width="180px">
				<input name='studentsids' type='hidden' value=''/>               
            </td>
        </tr>
        <tr>
            <td align="right" width="50px">条件2</td>
            <td align="left">
               
            </td>
        </tr>
        <tr>
            <td align="right" width="50px">条件3</td>
            <td align="left">
               
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
