<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속	
include "../../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$type = $_GET['type'];

$site_name = $_POST['site_name'];				//사이트명
$com_name = $_POST['com_name'];					//회사명
$ceo_name = $_POST['ceo_name'];					//대표자명

$business_num1 = $_POST['business_num1'];		//사업자 등록 번호
$business_num2 = $_POST['business_num2'];
$business_num3 = $_POST['business_num3'];
$business_num = $business_num1.$business_num2.$business_num3;

$corporate_num1 = $_POST['corporate_num1'];		//법인 등록 번호
$corporate_num2 = $_POST['corporate_num2'];
$corporate_num = $corporate_num1.$corporate_num2;

$mailorder_num = $_POST['mailorder_num'];		//통신 판매 신고 번호
$zip1 = $_POST['zip1'];							//우편번호
$zip2 = $_POST['zip2'];			
$zip = $zip1.$zip2;

$address1 = $_POST['address1'];					//주소
$address2 = $_POST['address2'];					//나머지 주소
$tel1 = $_POST['tel1'];							//전화번호
$tel2 = $_POST['tel2'];
$tel3 = $_POST['tel3'];
$tel = $tel1.'-'.$tel2.'-'.$tel3;

$fax1 = $_POST['fax1'];							//팩스
$fax2 = $_POST['fax2'];
$fax3 = $_POST['fax3'];
$fax = $fax1.'-'.$fax2.'-'.$fax3;

$email = $_POST['email'];						//이메일


$info_name = $_POST['info_name'];				//개인정보보호 담당자명
$info_team = $_POST['info_team'];				//소속
$info_tel1 = $_POST['info_tel1'];				//전화
$info_tel2 = $_POST['info_tel2'];
$info_tel3 = $_POST['info_tel3'];
$info_tel = $info_tel1.'-'.$info_tel2.'-'.$info_tel3;

$info_position = $_POST['info_position'];		//직위
$info_email = $_POST['info_email'];				//이메일


$domain = $_POST['domain'];						//도메인 주소
$domain_company = $_POST['domain_company'];		//구입업체
$domain_ex = $_POST['domain_ex'];				//만료일

if ($type =='add') {
	$sql1 = "insert into 
		site_info (
			si_site_name,
			si_com_name,
			si_ceo_name,
			si_business_num,
			si_corporate_num,
			si_mailorder_num,
			si_zipcode,
			si_address,
			si_address_detail,
			si_tel,
			si_fax,
			si_email,						
			si_info_name,
			si_info_team,
			si_info_tel,
			si_info_position,
			si_info_email,
			si_domain,
			si_domain_company,
			si_domain_ex
		)values(
			'$site_name',
			'$com_name',
			'$ceo_name',
			'$business_num',
			'$corporate_num',
			'$mailorder_num',
			'$zip',
			'$address1',
			'$address2',
			'$tel',
			'$fax',
			'$email',
			'$info_name',
			'$info_team',
			'$info_tel',
			'$info_position',
			'$info_email',
			'$domain',
			'$domain_company',
			'$domain_ex'
		)";
	$sql = @mysqli_query($CONN['rosemary'],$sql1);
						echo $sql;
	if (!$sql) {
		$t_chk = false;
		$err_msg = '등록 중 오류가 발생 하였습니다.';
	} else {
		$t_chk = true;
	}

} else {

	$update_query = "update site_info
					 set 
						si_site_name = '$site_name',
						si_com_name = '$com_name',
						si_ceo_name = '$ceo_name',
						si_business_num = '$business_num',
						si_corporate_num = '$corporate_num',
						si_mailorder_num = '$mailorder_num',
						si_zipcode = '$zip',
						si_address = '$address1',
						si_address_detail = '$address2',
						si_tel = '$tel',
						si_fax = '$fax',
						si_email = '$email',						
						si_info_name = '$info_name',
						si_info_team = '$info_team',
						si_info_tel = '$info_tel',
						si_info_position = '$info_position',
						si_info_email = '$info_email',
						si_domain = '$domain',
						si_domain_company = '$domain_company',
						si_domain_ex = '$domain_ex'
			";

	
	$sql = @mysqli_query($CONN['rosemary'],$update_query);


						
	if (!$sql) {
		$t_chk = false;
		$err_msg = '등록 중 오류가 발생 하였습니다.';
	} else {
		$t_chk = true;
	}
}

if($t_chk)
{	
	write_site_info();
	alertGo("","../index.php");
} else {
	alertback($err_msg);
}

// 사이트 기본 정보를 파일에 기록합니다.
function write_site_info()
{
	global $DOCUMENT_ROOT, $CONN;
	
	$site_info_list_query = mysqli_query($CONN['rosemary'], 'SELECT * FROM site_info;');
	while ($site_info_row = mysqli_fetch_array($site_info_list_query, MYSQL_ASSOC)) {
		foreach($site_info_row as $site_info_key => $site_info_val) {			
			$contents = $contents."$"."siteinfo['".$site_info_key."'] = '".$site_info_val."';\n";			
		}		
	}
	
	writeFile($DOCUMENT_ROOT.'/_autocode/siteinfo.php', getPHPTagString($contents));
}
?>
