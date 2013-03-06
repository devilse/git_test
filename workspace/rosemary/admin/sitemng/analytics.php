<div class="divtitle">
접속통계 확인
</div>
<br />
<?php
$analytics_cnt = 0;
if($siteoption['analytics_n_use'] == 'Y') {	
	$analytics_cnt++;
?>
<table class="optiontable">
	<caption>네이버 애널리틱스</caption>
	<tr>		
		<td class="title">통계 확인 URL</td>
		<td><a href="http://analytics.naver.com" target="_blank" class="underline">http://analytics.naver.com</a></td>
	</tr>
	<tr>		
		<td class="title">네이버 아이디</td>
		<td><?php echo $siteoption['analytics_n_lo_id'];?></td>
	</tr>
	<tr>		
		<td class="title">설명</td>
		<td>네이버에서 제공하는 통계서비스를 이용하고 있습니다. 통계확인 URL로 접속하여 네이버 아이디로 로그인 한 후 통계를 확인하시기 바랍니다.</td>
	</tr>
</table>
<br />
<?php
} 
?>

<?php
if($siteoption['analytics_g_use'] == 'Y') {
	$analytics_cnt++;
?>
<table class="optiontable">
	<caption>구글 웹로그 분석</caption>
	<tr>		
		<td class="title">통계 확인 URL</td>
		<td><a href="http://www.google.com/analytics" target="_blank" class="underline">http://www.google.com/analytics</a></td>
	</tr>
	<tr>		
		<td class="title">구글 아이디</td>
		<td><?php echo $siteoption['analytics_g_lo_id'];?></td>
	</tr>
	<tr>		
		<td class="title">설명</td>
		<td>구글에서 제공하는 통계서비스를 이용하고 있습니다. 통계확인 URL로 접속하여 구글 아이디로 로그인 한 후 통계를 확인하시기 바랍니다.</td>
	</tr>
</table>
<?php
}

if($analytics_cnt == 0) {
?>
활성화된 접속통계서비스가 없습니다.<br /> 
접속통계서비스를 사용하려면 <a href="/admin/sitemng/index.php?mode=etc" class="underline bold">기타 옵션</a>으로 가셔서 설정을 변경하시기 바랍니다. 
<?php
} 
?>