<?php include $DOCUMENT_ROOT."/admin/include/sitemap.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $siteinfo['si_site_name']; ?> 관리자</title>

<style type="text/css">
html {overflow: scroll; overflow-x: auto;}
body, td, p, input, button, textarea, select, .c1 { font-family:Tahoma,굴림; font-size:9pt; color:#222222; }
ul{list-style:none;}

form { margin:0px; }

/* img {border:0px;} */

a:link, a:visited, a:active { text-decoration:none; color:#466C8A; }
a:hover { text-decoration:none; }

a.menu:link, a.menu:visited, a.menu:active { text-decoration:none; color:#454545; }
a.menu:hover { text-decoration:none; }

input.ed { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; }
input.ed_password { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; font:10px Tahoma; }
textarea.tx { border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:2px; }

.divtitle { text-align:center; background-color:#EFEFEF; border-width: 1px; border-color: #999999; border-style:solid; padding-top:8px; padding-bottom:8px; font-weight:bold; }
.divbutton { text-align:right; }

.optiontable { width:100%; border-top:1px solid #999999; border-right:1px solid #999999; border-spacing:0px; border-collapse:collapse; }
.optiontable caption { text-align:center; font-weight:bold; background-color:#EFEFEF; border-top:1px solid #999999; border-left:1px solid #999999; border-right:1px solid #999999; padding:5px; }
.optiontable td { padding: 5px; line-height:180%; }
.optiontable th { background-color:#EFEFEF; font-weight: normal; }
.optiontable td, .optiontable th { border-bottom:1px solid #999999; border-left:1px solid #999999; padding: 5px; }
.optiontable .title { width:20%; background-color:#EFEFEF; height:22px; padding-left:5px; }

.listtable { width:100%; border-top:1px solid #999999; border-right:1px solid #999999; border-spacing:0px; border-collapse:collapse; }
.listtable caption { text-align:center; font-weight:bold; background-color:#EFEFEF; border-top:1px solid #999999; border-left:1px solid #999999; border-right:1px solid #999999; padding:5px; }
.listtable th { background-color:#EFEFEF; font-weight: normal; }
.listtable td, .listtable th { border-bottom:1px solid #999999; border-left:1px solid #999999;  padding: 5px; }
.listtable .title { width:20%; background-color:#EFEFEF; height:22px; padding-left:5px; }
.listtable tfoot tr td { text-align:center; }

.listtabletopinfo { text-align:right; }

.listtablesearch { text-align:center; }

.underline, .underline:link, .underline:visited, .underline:active .underline:hover { text-decoration:underline; }
.bold { font-weight:bold; }
 
/* 페이지리스트 */
.bod_pagelist{margin-top:25px;}
.bod_pagelist li{display:inline; color:#3a3a3a; font-weight:bold; margin:0 5px; font-size:1.1em;}
.bod_pagelist img{vertical-align:middle;}


.comment{margin-top:30px; width:100%; background-color:#f9f9f9; border-top:2px solid #cdcdcd; border-bottom:1px solid #ededed; color:#707070;}
.comment p{font-weight:bold; margin-bottom:3px;}
.com_list li{border-bottom:1px solid #ededed; padding:10px 20px; line-height:1.4em; text-align:left;}
.com_title{border-bottom:1px solid #ededed; padding:10px 20px; color:#4b728d; font-weight:bold; text-decoration:underline;}
.comment div{height:80px; padding:25px 0 0 25px;}
.comment div input{margin-left:10px;}

</style>


</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="82" align="center" valign="top" bgcolor="5b4d3f" style="padding:4px 0 0 0px;"><table width="980" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="18" height="74"></td>
        <td width="945"><table width="945" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="810"><table border="0" cellspacing="0" cellpadding="0">
                <tr>

				
				
					<td width="110" align="left" style="padding:0 5px 0 5px;"><a href="/admin/"><font color=silver><b>home</b></font></a></td>

					<td align="center" style="padding:0 5px;"></td>

<?php
					// 루프 돌면서 메뉴를 표시합니다.										
					foreach($sitemap as $keys => $val) {
?>						
					<td align="center" style="padding:0 5px;">|</td>
					<td align="center" style="padding:0 5px;">
<?php
						if(substr($current_menu_code, 0, 2) == $keys) {
							// 선택된 메뉴일 경우
							echo "<a href=\"$val[1]\"><font color=red><b>$val[0]</b></font></a>";
						} else {
							echo "<a href=\"$val[1]\"><font color=silver><b>$val[0]</b></font></a>";
						}
?>					
					</td>										
<?php						
					} 
?>
                </tr>
            </table></td>
            <!-- 륜 수정 -->
            <td width="281" align=absmiddle>
            <table width="300" height="53" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="112"><div align="right"><span class="style5"><font color=silver><?php echo $User_Info['name'];?> </font><font color=#FFFFFF>님</font>
                   | <a href="/web/member/process/logout.php"><font color=silver>로그아웃</font></a></span></div></td>
                </tr>

  
            </table></td>
          </tr>
        </table></td>

      </tr>
    </table></td>
  </tr>      
  <!-- 륜 끝 -->
  <tr>
    <td height="1" bgcolor="3e322c"></td>
  </tr>
  <tr>
    <td height="4" bgcolor="cfcfcf"></td>
  </tr>
  <tr>
    <td height="3" bgcolor="ececec"></td>
  </tr>
</table>
<table width="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>

<!--탑메뉴 끝-->
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="table-layout:fixed">

<tr>
<?php
if($current_menu_code == "main") {
	// main일 경우에는 왼쪽 메뉴가 없습니다.	
?>
	<td height="550" valign="top">
<?php	
} else {
?>
	<!-- 왼쪽 메뉴 시작 -->
	<td width = "200" valign="top">
		<?php include $DOCUMENT_ROOT."/admin/include/left_menu.php";?>
	</td>
	<!-- 왼쪽 메뉴 끝 -->	
    <td width="90%" height="550" valign="top">
<?php	
}
?>