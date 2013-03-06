<?
// 이파일은 템플릿파일들의 공용으로 사용할 인크루드 파일임. 해당 페이지에서 각종 디비선언및 변수및 유알엘설정을 다함.
include $_SERVER['DOCUMENT_ROOT'].'/_lib/global.php';
include $_SERVER['DOCUMENT_ROOT'].'/_lib/function.php';			// 각종 정보및 공용 루틴으로 사용할 함수들 정보		
include $_SERVER['DOCUMENT_ROOT'].'/_lib/db_conn.php';			// 디비 접속 정보(모든 디비 접속 정보가 담겨 있음)
include $_SERVER['DOCUMENT_ROOT'].'/_lib/lib.php';				// 공용 함수
include $_SERVER['DOCUMENT_ROOT'].'/_autocode/sitemap.php';		// 사이트맵
include $_SERVER['DOCUMENT_ROOT'].'/_autocode/cs_skin.php';		// cs 스킨
include $_SERVER['DOCUMENT_ROOT'].'/_autocode/category.php';	// 사이트의 카테고리
include $_SERVER['DOCUMENT_ROOT'].'/Template.class.php';		//템플릿 클래스 파일(템플릿 생성 함수임 신경쓸 필요 없음)

$tpl = new Template($siteinfo, $siteoption, $sitemap, $site_category); 


include $_SERVER['DOCUMENT_ROOT'].'/_lib/tem_global.php';		//템플릿 공용 변수

?>