<script language="javascript">
<!--
var _editor_url = "<?=$editor_Url?>";
var _contentValue = "<?=$contentForm?>";
var _contentName = "<?=$formName?>";
var _i_uploaded = "<?=$upload_image?>";
var _m_uploaded = "<?=$upload_media?>";

function editor_wr_ok(){
	document.<?=$formName?>.<?=$contentForm?>.value = SubmitHTML();
	//document.<?=$formName?>.submit();
}

//-->
</script>



<table align="center" border="0" cellpadding="1" cellspacing="3" width="100%">
	<tr>
		<td bgcolor="#EFEFEF">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr><td height="2"></td></tr>			
			<tr>
				<td>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" id=menu_bar>
	
					<tr>
						<td height="28">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_4.gif" border="0" TITLE='새문서' ONCLICK="newDoc()" align="absmiddle">
						<img style="cursor:hand;" src="<?=$editor_Url?>/img/edit_1.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('cut')" TITLE="자르기">
						<img style="cursor:hand;" src="<?=$editor_Url?>/img/edit_2.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('copy')" TITLE="복사">
						<img style="cursor:hand;" src="<?=$editor_Url?>/img/edit_3.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('paste')" TITLE="붙여넣기">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_5.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('outdent')" TITLE="내여쓰기">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_6.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('indent')" TITLE="들여쓰기">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_7.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('superscript')" TITLE="위첨자">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_8.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('subscript')" TITLE="아래첨자">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_9.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('undo')" TITLE="실행취소">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_10.gif" border="0" align="absmiddle" ONCLICK="htmlfalse('redo')" TITLE="재실행">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_5.gif" border="0" TITLE='Left' ONCLICK="htmlfalse('justifyleft')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_6.gif" border="0" TITLE='Center' ONCLICK="htmlfalse('justifycenter')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_7.gif" border="0" TITLE='Right' ONCLICK="htmlfalse('justifyright')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_10.gif" border="0" TITLE='숫자로 된 목록' ONCLICK="htmlfalse('insertorderedlist')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_11.gif" border="0" TITLE='점으로 된 목록' ONCLICK="htmlfalse('insertunorderedlist')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_18.gif" align="absmiddle" border="0" oNCLICK="htmlfalse('inserthorizontalrule');" title="가로선">
						</td>
					</tr>
				
					<tr>
						<td height="28">
					
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_11.gif" border="0" TITLE='글꼴' ONCLICK="createHTML('fontname',4);" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/edit_12.gif" border="0" TITLE='글자 크기' ONCLICK="createHTML('fontsize',7);" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_1.gif" border="0" TITLE='진하게' ONCLICK="htmlfalse('bold')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_2.gif" border="0" TITLE='이탤릭' ONCLICK="htmlfalse('italic')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_3.gif" border="0" TITLE='취소선' ONCLICK="htmlfalse('strikethrough')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_4.gif" border="0" TITLE='밑줄' ONCLICK="htmlfalse('underline')" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_8.gif" border="0" TITLE='글자색' onclick="createHTML('forecolor',5);" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_9.gif" border="0" TITLE='글자 배경색' onclick="createHTML('backcolor',6);" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_12.gif" border="0" TITLE='하이퍼링크 만들기' ONCLICK="createHTML('CreateLink',8);" align="absmiddle">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_16.gif" border="0" onclick="createHTML('',1);" align=absmiddle title="표 삽입">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_19.gif" align="absmiddle" border="0" title="특수문자" onclick="createHTML('',2);">
						<img style="cursor:hand;cursor:pointer;" src="<?=$editor_Url?>/img/item_20.gif" align="absmiddle" border="0" title="아이콘" onclick="createHTML('InsertImage',3);" align="absmiddle">
				
		
						</td>
					</tr>
					<tr><td height="2"></td></tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<TABLE BORDER="1" WIDTH=100% cellspacing="0" bordercolor="#EFEFEF" bordercolordark="white" bordercolorlight="#DBDBDB">
			<TR>
				<TD>
				<iframe id="gmEditor" WIDTH="<?=$textWidth?>" HEIGHT="<?=$textHeight?>" scrolling="auto" border=1 frameborder=0 framespacing=0 hspace=0 marginheight=0 marginwidth=0 vspace=0 style=""></iframe>
				<textarea cols=0 rows=0 style="display:none;" wrap='physical' name="<?=$contentForm?>"><?=$content?></textarea>
				<input type="hidden" id="ReturnUrl" name="ReturnUrl" value="<?=$editor_Url?>">
				<script language="javascript" src='<?=$editor_Url?>/gmEditor.js'></script>
				</TD>
			</TR>
		</TABLE>
		</td>
	</tr>
</table>
