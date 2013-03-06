<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";	
include "../../../_lib/global.php";	
include "../../../_lib/lib.php";

setcookie("LIPASS_ID","",0,"/");

if(empty($_GET['prev'])) {
	alertGo("", "../../main/index.php");
} else {
	alertGo("", urldecode($_GET['prev']));
}
?>