<?php /* Template_ 2.2.7 2013/01/09 12:40:23 C:\rosemary\trunk\src\rosemary\_template\skin\class\basic\pop_lecture.html 000004422 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>라이패스LS</title>
<meta name="author" content="nanumcommunications"/>
<meta name="robots" content="all"/>
<meta name="keywords" content="nanumcommunications, 나눔커뮤니케이션즈, 자격증, license, Lipass, 국가기술자격증, 학점인정, 학위취득, 공무원, 국가기술, 유망자격증, 교수, 강좌, 기능사, 기사, 산업기사"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/class/basic/css/mylecture.css"/>
<script type="text/javascript" src="../../../../_js//cufon-yui.js"></script>
<script type="text/javascript" src="../../../../_js//NanumGothic_400-NanumGothic_Bold_400.font.js"></script>
<script type="text/javascript">
Cufon.replace('.sr_head02>h3');
</script>
</head>
<body>
<div id="pop_lecture">
<ul class="pop_menu">
<li class="on"><a href="#">강의실</a></li>
<li><a href="#">강의자료실</a></li>
<li class="last"><a href="#">질의응답</a></li>
</ul>
<div class="lec_box">
<?php $this->print_("content",$TPL_SCP,1);?>
<!--2222222222222222222222222222222222222-->
<!--33333333333333333333333-->
<div id="tab_info3" style="display:none;">
<!-- 수강 기본 정보 시작 -->
<div class="myinfo_box">
<dl class="info01">
<dt>동영상강의정보</dt>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info101.gif" alt="수강중인강의" /><span>1</span>개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info102.gif" alt="수강예정강의" />1개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info103.gif" alt="수강종료강의" />1개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info104.gif" alt="수강중지강의" />1개</dd>
</dl>
<dl class="info02">
<dt>결제정보</dt>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info201.gif" alt="결제완료" /><span>1</span>개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info202.gif" alt="결제대기" />1개</dd>
</dl>
<dl class="info03">
<dt>유의사항</dt>
<dd class="no_bor">상세보기 버튼을 클릭하여 수강하셨던 강의의 상세정보를 보실수 있습니다</dd>
</dl>
</div>
<!-- 수강 기본 정보 끝 -->
<div class="page_tit">
<img src="/_template/skin/class/basic/images/mylecture/or_title_my01.gif" alt="수강정보" />
</div>
<!-- 탭 시작 -->
<ul class="page_tab">
<li><a href="#">수강중인강의</a></li>
<li><a href="#">수강예정강의</a></li>
<li class="on"><a href="#">수강종료강의</a></li>
</ul>
<!-- 탭 끝 -->
<table cellpadding="0" cellspacing="0" border="0" class="myinfo_bod">
<caption></caption>
<colgroup>
<col width="58%" />
<col width="10%" />
<col width="20%" />
<col width="12%" />
</colgroup>
<tbody>
<tr>
<th>강의명</th>
<th>교수명</th>
<th>결제일</th>
<th>상세보기</th>
</tr>
<tr>
<td class="lec_tit">정보통신기사 실기 필기 종합</td>
<td>교수명</td>
<td><img class="ico_date" src="/_template/skin/class/basic/images/mylecture/ico_start.gif" alt="시작일" />2013-01-16<br /><img class="ico_date" src="/_template/skin/class/basic/images/mylecture/ico_end.gif" alt="종료일" />2013-01-16</td>
<td><input name="" class="grey_btn_lec" type="button" value="상세보기"/></td>
</tr>
</tbody>
</table>
<!-- LS 페이징 -->
<ul class="bod_pagelist">
<li><a href="#"><img src="/_template/skin/class/basic/images/mylecture/btn_all_prev.gif"></a>
<a href="#"><img src="/_template/skin/class/basic/images/mylecture/btn_prev.gif"></a></li>
<li class="on"><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">5</a></li>
<li><a href="#">6</a></li>
<li><a href="#">7</a></li>
<li><a href="#"><img src="/_template/skin/class/basic/images/mylecture/btn_next.gif"></a>
<a href="#"><img src="/_template/skin/class/basic/images/mylecture/btn_all_next.gif"></a></li>
</ul>
<!-- LS 페이징 끝 -->
</div>
</div>
</div>
</body>
</html>