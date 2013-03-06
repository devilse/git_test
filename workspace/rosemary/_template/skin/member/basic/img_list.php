<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
header('Content-Type: text/html;charset=euc-kr');
require_once $_SERVER[DOCUMENT_ROOT] . "/_include/declare.php";	//카페기본경로 
require_once $BASE_DIR . "/_include/globals.php";	//카페 접근 체크
require_once $BASE_DIR . "/_include/myalert.php";	//alert 창
require_once "/home/hosting/my.script/connect_db.php";
include	 "../_lib/function.php";
chkLogin();

$CONN[webhard]	 =	 DB_CONN("webhard");

include "../_config/board_config.php";

include "../_include/2010_top.php";

include "../_include/new_top.php";
include "../_include/new_left.php";
//include "../_include/top_search_new3.php";
echo '<td width="10"></td>
<td width="760" valign="top">';


$NOW_DATE = date('Y-m-d');

$singo_table =  "webhard_new.adult_img_singo";



$chk=chkAdmin($USER_INFO[0]);

if(!$chk){
		myalert(0,"접근권한이 없습니다.");
}

//알바
/*
if($USER_INFO[0] == "nmimn"){
	$chk = 1;
}
*/

			$first = $num_per_page * ($page - 1);
			$limit = "limit $first, $num_per_page";

			//$where	 =	 " and A.id='$USER_INFO[0]'";


			if($keys && $searchwords) {
				if($keys == "title"){
					$where	 .=	 "and  $keys LIKE '%$searchwords%' ";
				}else if($keys == "reg_nick"){
					$where	 .=	 "and  $keys = '$searchwords' ";
				}else if($keys == "regdate"){
					$where	 .=	 "and  left(from_unixtime(regdate),10) = '$searchwords'";
				}else if($keys == "reg_id"){
					$where	 .=	 "and  $keys = '$searchwords' ";
				}else if($keys == "singo_id"){
					$where	 .=	 "and  $keys = '$searchwords' ";
				}
				
			}

			if($state_sel){
				$where	 .=	 "and  state = '$state_sel' ";
			}

			if($sort_sel){
				$where	 .=	 "and  sort = '$sort_sel' ";
			}

			if($admin_chk){
				$where	 .=	 "and  admin_chk = '$admin_chk' ";
			}


			if($_GET[sel_y]){
				$sel_date = $_GET[sel_y]."-".$_GET[sel_m]."-".$_GET[sel_d];
				if($sel_date != "2009-01-01"){
					$where	 .=	 "and  left(from_unixtime(singo_date),10) = '$sel_date'";
				}else{
					$_GET[sel_y] = "";
					$_GET[sel_m] = "";
					$_GET[sel_d] = "";
				}
			}



if($chk){
	$singo_tot = chkDbQry("select num from $singo_table where 1=1",1);
	$singo_tot_num = mysql_num_rows($singo_tot);
	$singo_wan = chkDbQry("select num from $singo_table where 1=1 and state != '2'",1);
	$singo_wan_num = mysql_num_rows($singo_wan);
	$singo_m = chkDbQry("select num from $singo_table where 1=1 and state = '2'",1);
	$singo_m_num = mysql_num_rows($singo_m);
	$singo_day = chkDbQry("select num from $singo_table where 1=1 and state = '2' and left(from_unixtime(singo_date),10) = '$NOW_DATE'",1);
	$singo_day_num = mysql_num_rows($singo_day);
	


}

$query_vlaue =  $where."||".$sel_date."||".$state_sel."||".$cate_id."||".$keys."||".$searchwords;
?>
<script>
function form_check(){
	//검색어
	if(!check_form.searchwords.value){
		window.alert('검색어를 입력해 주세요');
		check_form.searchwords.focus();
		return;
	}

check_form.submit();
}
function end_wait(){
	alert("현재 처리대기중 입니다.");
}

function allCheck()
{
	var f = document.forms['list_form'];
	if(typeof(f.chk_list) == 'object') {
		if(f.allchk.checked) {
			if(f.chk_list.length) for (var i=0;i<f.chk_list.length;i++) f.chk_list[i].checked=true;
			else f.chk_list.checked=true
		} else {
			if(f.chk_list.length) for (var i=0;i<f.chk_list.length;i++) f.chk_list[i].checked=false;
			else  f.chk_list.checked=false;
		}
	} else {
		if(f.allchk.checked) {
			alert('선택할 글이 없습니다.');f.allchk.checked = false;return;
		} else return;
	}
}
function all_del(){
	if(confirm("선택한 게시물을 삭제 하시겠습니까? 처리대기중인 게시물은 삭제 되지 않습니다.")){
		var form = document.list_form;
		var arr_files_list = new Array();
		var chkBox_files = form.chk_list;
		if(form.chk_list.checked){
			var check_ok = "yes";
		}

		var chkLen_files = chkBox_files.length;
		if(check_ok == "yes" && !chkLen_files){
			chkLen_files = 1;		
		}
		var index = 0;
			if(chkLen_files == 1){
				arr_files_list[index]=chkBox_files.value;
			}else{
				for (i = 0; i < chkLen_files; i++) 
				{
					if (chkBox_files[i].checked)
					{
						arr_files_list[index]=chkBox_files[i].value;
						index++;
					}
				}
			}

		form.mmsv_files.value ="";
		form.mmsv_files.value = arr_files_list;

		if(form.mmsv_files.value == ""){
		alert("선택한글이 없습니다.");
		return;
		}
		form.mmsv_files.value ="";
		form.mmsv_files.value = arr_files_list.join("<>");
		form.submit();
	}
		
}

	function send_view(val){
		var submenu = document.getElementById(val);
		var f = document.img_form;
		//var comment=document.getElementById('opn_comment');
		if(submenu.style.display == "none"){
			submenu.style.display="block"
			if(f.y_sel.value == ""){
				f.y_sel.value = val;
			}else{
				var y_menu=document.getElementById('y_sel');
				var submenu2 = document.getElementById(y_menu.value);
				submenu2.style.display="none";
				f.y_sel.value = val;
			}
		}else{
			submenu.style.display="none";
		}
	}
function img_fixed(){
}


function send_go(val,mode,num){

	var f = document.img_form;
	f.mode.value = mode;
	f.y_sel2.value = num;
	f.target="scrap_target";
	f.action="../_action/img_singo_process.php";	
	f.submit();


		var submenu = document.getElementById(val);
		var val2 = parseInt(val) - parseInt(1);
		

			submenu.style.display="none";
			var y_menu=document.getElementById('y_sel');
			var submenu2 = document.getElementById(val2);
			submenu2.style.display="block";
			f.y_sel.value = val2;
			
			location.href="#first_"+val2;
}

function send_go2(val,mode,num){

	var f = document.img_form;
	f.mode.value = mode;
	f.y_sel2.value = num;

		var submenu = document.getElementById(val);
		var val2 = parseInt(val) - parseInt(1);
		

			submenu.style.display="none";
			var y_menu=document.getElementById('y_sel');
			var submenu2 = document.getElementById(val2);
			submenu2.style.display="block";
			f.y_sel.value = val2;
			
			location.href="#first_"+val2;
}

</script>



	<table width="760"  border="0" cellspacing="0" cellpadding="0">
<form name = "img_form">
<input type = "hidden" name = "mode">
<input type = "hidden" name = "y_sel">
<input type = "hidden" name = "y_sel2">
</form>
	<tr>
	<td><img src="http://imgser.gample.net/webhard/images/stit_my.gif" width="760" height="27"></td>
	</tr>
	<tr>
	<td background="http://imgser.gample.net/webhard/images/box_bg.gif">

		<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		<td width="47%" class="bbs_line01"><img src="http://imgser.gample.net/webhard/images/icon/deco_03.gif" align="absmiddle">전체 신고 게시물 : <b class="text_red02"><?=number_format($singo_tot_num)?>개</b></td>
		<td width="48%" class="bbs_line01"><img src="http://imgser.gample.net/webhard/images/icon/deco_03.gif" align="absmiddle">처리 완료 : <b class="text_red02"> <?=number_format($singo_wan_num)?>개</b></td>
		</tr>
		<tr>
		<td height="30" class="text_blue"><img src="http://imgser.gample.net/webhard/images/icon/deco_03.gif" align="absmiddle">처리 대기중 : <b class="text_red02"><?=number_format($singo_m_num)?>개</b></td>
		<td class="text_blue"><img src="http://imgser.gample.net/webhard/images/icon/deco_03.gif" align="absmiddle">금일 대기중 : <b class="text_red02"><?=number_format($singo_day_num)?>개</b></td>
		</tr>
		</table>

	</td>
	</tr>
	<tr>
	<td><img src="http://imgser.gample.net/webhard/images/box_foot.gif"></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	</table>

	<!--bbs list -->
	<table width="760" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td><img src="http://imgser.gample.net/webhard/images/bbs_img/icon/deco_arrow02.gif" width="13" height="12"> <b class="text_blue">음란 본문 신고처리 게시판</td>
		<td align="right">
			<form name=f action="<?=$REQUEST_URI?>"  style="margin:0px">
			<input type="hidden" name="keys" value="<?=$keys?>">
			<input type="hidden" name="searchwords" value="<?=$searchwords?>">
			<input type="hidden" name="cate_id" value="<?=$cate_id?>">
			<input type="hidden" name="page" value="<?=$page?>">
<?
	if($chk){
		if($where){
?>
<!--<a href="./singo_excel2.php?val=<?=$query_vlaue?>">엑셀파일생성</a>-->
<?
	}else{
?>
<!--<a href="javascript:alert('검색을 하시고 사용 하세요.');">엑셀파일생성</a>-->
<?
}}?>
<?
	//$sel_year = date("Y");
$sel_year = "2009";
	//$sel_mon = date("m");
	//$sel_day = date("d");
?>
			<select name = "sel_y">
				<?for($i=$sel_year;$i<$sel_year+2;$i++){?>
					<option value = "<?=$i?>" <?if($i == $sel_y){?>selected<?}?>><?=$i?></option>
				<?}?>
			</select>

			<select name = "sel_m">
				<?
					for($i=1;$i<13;$i++){
						if($i<10) $i="0".$i;
				?>
					<option value = "<?=$i?>" <?if($i == $sel_m){?>selected<?}?>><?=$i?></option>
				<?}?>
			</select>

			<select name = "sel_d" onChange="this.form.submit()">
				<?
					for($i=1;$i<32;$i++){
						if($i<10) $i="0".$i;
				?>
					<option value = "<?=$i?>" <?if($i == $sel_d){?>selected<?}?>><?=$i?></option>
				<?}?>
			</select>

			<select name="sort_sel" onChange="this.form.submit()">
			<option value="" <?if($_GET[sort_sel] == "" and !$_GET[sort_sel]){?>selected<?}?>>전체</option>
			<option value="1" <?if($_GET[sort_sel] == "1" ){?>selected<?}?>>미성년물</option>
			<option value="2" <?if($_GET[sort_sel] == "2" ){?>selected<?}?>>음란물</option>
			</select>


			<select name="state_sel" onChange="this.form.submit()">
			<option value="" <?if($_GET[state_sel] == "" and !$_GET[state_sel]){?>selected<?}?>>전체</option>
			<option value="2" <?if($_GET[state_sel] == "2" ){?>selected<?}?>>대기중</option>
			<option value="1" <?if($_GET[state_sel] == "1" ){?>selected<?}?>>처리완료</option>
			</select>


			<select name="admin_chk" onChange="this.form.submit()">
			<option value="" <?if($_GET[admin_chk] == "" and !$_GET[state_sel]){?>selected<?}?>>전체</option>
			<option value="Y" <?if($_GET[admin_chk] == "Y" ){?>selected<?}?>>관리자신고</option>
			<option value="N" <?if($_GET[admin_chk] == "N" ){?>selected<?}?>>회원신고</option>
			</select>


			<select name="num_per_page" onChange="this.form.submit()">
			<option value="20" <?echo$num_per_page==20?"selected":"";?>>20개씩 보기</option>
			<option value="50" <?echo$num_per_page==50?"selected":"";?>>50개씩 보기</option>
			</select>
		</td>
		</form>
<form name = "list_form" method="post" action="./new_singo_process.php">
<input type = "hidden" name="mmsv_files">
<input type = "hidden" name="mode" value = "del">
			<input type="hidden" name="keys" value="<?=$keys?>">
			<input type="hidden" name="searchwords" value="<?=$searchwords?>">
			<input type="hidden" name="cate_id" value="<?=$cate_id?>">
			<input type="hidden" name="page" value="<?=$page?>">
		</td>
		<td ></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td height="5"></td>
	</tr>
	<tr>
	<td>
		<!--list -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td colspan="7">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" background="http://imgser.gample.net/2009main_new/image/sub/note/bg.gif" >
			<tr>
			<td><img src="http://imgser.gample.net/2009main_new/image/sub/note/left.gif" width="6" height="31"></td>
			<td width="27" align="center" class="bbs_txt11"><input type="checkbox" name="allchk" onClick="allCheck();this.blur()"></td>
			<td width="48" align="center" class="bbs_txt11"><strong>번호</strong></td>
			<td align="center"><img src="http://imgser.gample.net/2009main_new/image/sub/note/line.gif" width="2" height="28"></td>
			<td width="375" align="center" class="bbs_txt11"><strong>제목</strong></td>
			<td align="center"><img src="http://imgser.gample.net/2009main_new/image/sub/note/line.gif" width="2" height="28"></td>
			<td width="100" align="center" class="bbs_txt11"><strong>신고날짜</strong></td>
			<td align="center"><img src="http://imgser.gample.net/2009main_new/image/sub/note/line.gif" width="2" height="28"></td>
			<td width="113" align="center" class="bbs_txt11"><strong>등록자</strong></td>
			<td align="center"><img src="http://imgser.gample.net/2009main_new/image/sub/note/line.gif" width="2" height="28"></td>
			<td width="90" align="center" class="bbs_txt11"><strong>VIEW</strong></td>
			<td align="center"><img src="http://imgser.gample.net/2009main_new/image/sub/note/line.gif" width="2" height="28"></td>
			<td width="120" align="center" class="bbs_txt11"><strong>상    태</strong></td>

			<td align="right"><img src="http://imgser.gample.net/2009main_new/image/sub/note/right.gif" width="5" height="31"></td>
			</tr>
			</table>
		</td>
		</tr>
		<?

				$qry	=	"SELECT num FROM  $singo_table A  WHERE 1=1  $where";



			$rst	=	mysql_query($qry, $CONN[webhard]);
			$query_number	=	mysql_num_rows($rst);

			//$query_number	=	$temp[0];

			$number = $query_number - $first;

			if($query_number) {

					$qry	=	"SELECT * FROM  $singo_table A WHERE 1=1 $where order by A.num DESC $limit";

				//echo$qry;
				$rst	=	mysql_query($qry, $CONN[webhard]);

				while($row=mysql_fetch_array($rst)):
					$singo_date = date('Y-m-d',$row[singo_date]);
					if($row[state] == "2"){
						$state = "<font color=red><b>처리대기중</b></font>";
					}else{

						if($row[state] == "1"){
							$state_text = "<font color=red>음란 스샷으로 인해 차단 처리.</font>";
						}else if($row[state] == "3"){
							$state_text = "<font color=blue>음란 스샷이 아니므로 복원 처리.</font>";
						}else if($row[state] == "4"){
							$state_text = "음란 스샷이라고 보기엔 애매해서 복원 처리";
						}else{
							$state_text = "";
						}
						$bgcolor = "bgcolor='#F9F9F9'";
						$state = "처리완료";
					}
					$cate_id = $row[cate_id];
					$sort = cate_sel($cate_id);


				$num = $row[num];



				$content = stripslashes($row[origin_con]);
				$content = str_replace("\\'","'",$content);

				// 이미지 가로크기.
				$img_width = "500";

				// 본문과 첨부로 붙여진 코드 분리
				$tmp_content = explode("<@@__attach__@@>",$content);

				$tmp_cnt	 =	 substr_count($content,"<@@__attach__@@>");
				$content = $tmp_content[0];			// 실제 본문
				$content = eregi_replace("<@img_up_dir@>","http://cafephoto.gample.net/cafe_bbs_upfiles",$content);

				$content = eregi_replace("<img","<br><img onload=img_fixed(this) ",$content);
				$content = eregi_replace("\\\\","",$content);

		?>
		<tr onMouseOver="this.style.backgroundColor='#F9F9F9';" onMouseOut="this.style.backgroundColor='';" <?=$bgcolor?>>
		<td width="32" align="center" class="bbs_line01"><input type="checkbox" name="chk_list" value = "<?=$row[num]?>"></td>
		<td width="48" align="center" class="bbs_line01"><span class="bbs_num01"><?=number_format($number)?></span></td>
		<td width="295" class="bbs_line01">
		<a href="javascript:send_view('<?=$number?>')">
					<?=$sort?><?=$row[title]?> </a> <img src="http://imgser.gample.net/webhard/images/icon/icon_new.gif" hspace="2" align="absmiddle">
		</td>
		<td width="85" align="center" class="bbs_line01"><span class="bbs_link01"><?=$singo_date?></span></td>
	    <td width="100" align="center" class="bbs_line01"><span class="bbs_link01"><?=$row[reg_nick]?></span></td>

		<td width="70" align="center" class="bbs_line01"><a href="javascript:openWin('../_popup/pop_file_view.htm?num=<?=$row[list_num]?>&cate_id=<?=$cate_id?>','VIEW','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=820,height=700,top=0,left=0')" class="bbs_link01" >VIEW</a></td>
		<td width="100" align="center" class="bbs_line01"><?=$state?></td>
		</tr>
		<tr>
			<td colspan="7" align=center id = "<?=$number?>" style="display:none" >
			<table>  
				<tr>
					<td align = "center" 	style="word-break:break-all;" width=200>
							<a name="first_<?=$number?>"><?if($row[state] == "2"){?><?=$content?><?}else{?>처리완료된것임<br><?}?></a> <br><?if($row[state] != "2"){?><b><?=$content?><br><?=$state_text?></b><br><b>신고자 : <?=$row[singo_id]?></b><br><input type = "button" value = "처리완료된 게시물 입니다." onclick="send_go2('<?=$number?>','ok','<?=$num?>')">  <?}else{?> <b>신고자 : <?=$row[singo_id]?></b><br>
							<input type = "button" value = "처리하기" onclick="send_go('<?=$number?>','ok','<?=$num?>')"> <input type = "button" value = "거부하기" onclick="send_go('<?=$number?>','no','<?=$num?>')"> <input type = "button" value = "애매해서 거부하기" onclick="send_go('<?=$number?>','mo','<?=$num?>')"><?}?><br>
				</td>
				</tr>
				</table>

			</td>
		</tr>



		<?
			$user_sort = "";
			$bgcolor = "";
				$number--;
				endwhile;
			} else {
		?>
		<tr height="32" align="center">
			<td colspan="7">신고한 게시물이 없습니다.</td>
		</tr>
		<?}?>
		</table>
		<!--//list -->
	</td>
</form>
	</tr>
	<tr>
	<td height="10"></td>
	</tr>
	<tr>
	<td>
		<!--페이징 -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="150" height="30"><!--img src="http://imgser.gample.net/webhard/images/bbs_img/btn/btn_del.gif" width="58" height="27"--></td>
		<td align="center">
		<?
			$cate_id = $_GET[cate_id];
		?>
		
		<?=go_page4($query_number, $num_per_page, $num_per_block, $page, $PHP_SELF, $keys, $searchwords, $cate_id,$state_sel,$sel_y,$sel_m,$sel_d,$sort_sel)?> 

		</td>
		<td width="180" align="right">&nbsp;</td>
		</tr>
		<tr>
		<td height="30">&nbsp;</td>
		<td colspan="2" align="right"><?if(!$chk){?><a href="javascript:all_del()"><img src="http://imgser.gample.net/new/images/btn_17.gif"  border="0"></a><?}?></td>
		</tr>
		</table>
		<!--//페이징 -->
	</td>
	</tr>
	<tr>
	<td height="25">
		<table width="760" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8F8F8" style="margin:20px 0px 0px 0px ">
		<form name="check_form" method="post" action="<?=$PHP_SELF?>" onSubmit="form_check(); return false;">
        <tr>
          <td width="5" height="5"><img src="http://imgser.gample.net/customer/img/box/box05_left01.gif" width="5" height="5"></td>
          <td background="http://imgser.gample.net/customer/img/box/box05_mid01.gif"></td>
          <td width="5" height="5"><img src="http://imgser.gample.net/customer/img/box/box05_right01.gif" width="5" height="5"></td>
        </tr>
        <tr>
          <td background="http://imgser.gample.net/customer/img/box/box05_left02.gif"></td>
          <td align="center" bgcolor="#FFFFFF" style="padding:5px">
		  <select name="keys">
                <option value="title" <?if($keys=="title"){?>selected<?}?>>제 목</option>
				<option value="reg_nick" <?if($keys=="reg_nick"){?>selected<?}?>>판매자</option>
				<?if($chk){?><option value="reg_id" <?if($keys=="reg_id"){?>selected<?}?>>판매자아이디</option><?}?>
				<?if($chk){?><option value="singo_id" <?if($keys=="singo_id"){?>selected<?}?>>신고자아이디</option><?}?>
            </select>
              <input name="searchwords" type="text" class="input02" value="<?=$searchwords?>">
              <input type="image" src="http://imgser.gample.net/customer/img/btn/btn_search.gif" width="38" height="20" hspace="2" border="0" align="absmiddle">&nbsp;<a href="?">전체보기</a></td>
          <td background="../images/box/box05_right02.gif"></td>
        </tr>
        <tr>
          <td width="5" height="5"><img src="http://imgser.gample.net/customer/img/box/box05_left03.gif" width="5" height="5"></td>
          <td background="http://imgser.gample.net/customer/img/box/box05_mid02.gif"></td>
          <td width="5" height="5"><img src="http://imgser.gample.net/customer/img/box/box05_right03.gif" width="5" height="5"></td>
        </tr>
		</form>
      </table>	
	</td>
	</tr>
	</table>
	<!--//bbs list -->
	<!--box -->
	<!--//box -->
	<br>
	<br>
</td>
</tr>
<tr>
<td><img src="http://imgser.gample.net/webhard/images/leftmenu/left_box01_bottom02.gif" width="180" height="19"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>


</table>
<?include "../_include/bottom.php"?>
<br>
<iframe width="500" height="500" frameborder="0" hspace="0" vspace="0" id="scrap_target" name="scrap_target"  scrolling="no" ></iframe>
</body>
</html>
