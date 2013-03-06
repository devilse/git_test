<?php
function alert($msg)
{
		echo "<script type=\"text/javascript\">alert('$msg')</script>";
		exit;
}
function alertback($msg)
{
		echo "<script type=\"text/javascript\">
				alert('$msg');
				history.back();
			  </script>";
		exit;
}


function alertclose($msg)
{
		echo "<script type=\"text/javascript\">
				alert('$msg');
				self.close();
			  </script>";
		exit;
}
function alertGo($msg,$url=0,$target='self')
{
	echo '<script type="text/javascript">';
	if ($msg) {
		echo 'alert(\''.$msg.'\');';
	}
	if ($url) {
		echo 'window.'.$target.'.location.replace(\''.$url.'\');';
	}
	echo '</script>';
	exit;
}


function viewSizeToByte($total_size) //바이트변환
{
	if($total_size>0 && $total_size<1024) {
		$t_size	=	$total_size. " Byte";
	} elseif($total_size>1024 && $total_size<1024*1024) {
		$t_size	=	round($total_size/1024,2). " KB";
	} elseif($total_size>1024*1024 && $total_size<1024*1024*1024) {
		$t_size	=	round($total_size/1024/1024,2). " MB";
	} elseif($total_size>1024*1024*1024) {
		$t_size	=	round($total_size/1024/1024/1024,2). " GB";
	} 
	return $t_size;
}

function rshift($src, $scnt)
{
    for($i=0; $i < $scnt; $i++) {
       	$chk=$src & 0x01;
       	$src=$src >> 1;
       	if ($chk) {
			$src = $src | 0x80;
       	} else {
			$src= $src;
		}
    }

    return $src;
}

function lshift($src,$scnt)
{
    for($i=0; $i < $scnt; $i++) {
       	$chk=$src & 0x80;
       	$src=$src << 1;
       	if ($chk) {
			$src= $src | 0x01;
       	} else {
			$src= $src;
		}
    }

    return $src;
}

function skcrypt($src)
{

	$iptmp = 6;
    $cchar=0;
    $len=strlen($src);
    $gbg=8 - $len % 8;
    if ($gbg == 8) $gbg =0;
    else $gbg= $gbg;
    $len=$len + $gbg;
	$tmpsrc = $src;
	$computer = sprintf("%02x", $gbg);

    for($i=0; $i < strlen($tmpsrc); $i++) {
		$tmp[$i]=rshift(ord($tmpsrc[$i]), $iptmp);
	}

    for($i=0; $i < $len; $i+=8) {
		$flag=0x80;
		for($j=0; $j < 8; $j++) {
			$sum=0x80;
			$cchar=0;
			for($k=0; $k < 8; $k++) {
				if ($tmp[$i+$k] & $flag) {
					$cchar = $cchar + $sum;
				} else {
					$cchar = $cchar;
				}
				$sum=$sum >> 1;
			}
			$hex = sprintf("%02x", $cchar);
			$computer .= $hex;
			$flag=$flag >> 1;
		}
    }
    return $computer;
}

function skuncrypt($src)
{
	$iptmp = 6;
	$cchar=0;
	$len=strlen($src);
	$dptlen=$len/2;
	for($i=2, $j=0; $i < $len; $i+=2, $j++) {
	   if ($src[$i] >= A)
	   {
		   $digit = (((ord($src[$i]) & 0xdf) - ord(A)) +10)*16;
	   }else
	   {
		   $digit = $src[$i]*16;
	   }
	   if ($src[$i+1] >= A)
	   {
		   $digit += ((ord($src[$i+1]) & 0xdf) - ord(A)) +10;
	   }else
	   {
		   $digit += $src[$i+1];
	   }
		   $hexsrc[$j]=$digit;
	}

	for($i=0; $i < $dptlen - 1; $i+=8) {
		$flag=0x80;
		for($j=0; $j < 8; $j++) {
			$sum=0x80;
			$cchar=0;
			for($k=0; $k < 8; $k++) {
				if ($hexsrc[$i+$k] & $flag) {
					$cchar = $cchar + $sum;
				} else { 
					$cchar =  $cchar;
				}
				$sum=$sum >> 1;
			}
			$computer[$i+$j] =lshift($cchar, $iptmp);
			$flag=$flag >> 1;
		}
	}

	for($i=0;$i < sizeof($computer);$i++)
	{
		$data .=chr($computer[$i]);
	}

   return $data;
}
function okskcrypt($src)
{
	$ip = '61.78.60.80';
	$iptok0 = strtok($ip,".");
	$iptok1 = strtok(".");
	$iptok2 = strtok(".");
	$iptok3 = strtok(".");

	$iptmp = $iptok3%8;

    $cchar=0;
    $len=strlen($src);
    $gbg=8 - $len % 8;
    if ($gbg == 8){
		$gbg =0;
    } else { 
		$gbg= $gbg;
	}
    $len=$len + $gbg;
    $tmpsrc = $src;
    $computer = sprintf("%02x", $gbg);

    for ($i=0; $i < strlen($tmpsrc); $i++) {
		$tmp[$i]=rshift(ord($tmpsrc[$i]), $iptmp);
	}

    for ($i=0; $i < $len; $i+=8) {
        $flag=0x80;
        for($j=0; $j < 8; $j++) {
            $sum=0x80;
            $cchar=0;
            for($k=0; $k < 8; $k++) {
				if ($tmp[$i+$k] & $flag) {
					$cchar = $cchar + $sum;
				} else { 
					$cchar = $cchar;
				}
				$sum=$sum >> 1;
            }
            $hex = sprintf("%02x", $cchar);
            $computer .= $hex;
            $flag=$flag >> 1;
        }
    }
    return $computer;
}


	
// 페이징
function go_page($query_number, $num_per_page, $num_per_block, $page, $file_name, $key, $searchword,$mode)
{
	global $page_list_url;	
	$go_file = $file_name."user_num=$user_num&num_per_page=$num_per_page&mode=$mode&page";

	$searchword = urlencode($searchword);
	$total_page = @ceil($query_number / $num_per_page);
	$total_block = @ceil($total_page / $num_per_block);
	$block = @ceil($page / $num_per_block);

	//첫번째 페이지
	$first_page = ($block - 1) * $num_per_block;
	$first_page2 = 1;
	$last_page = $block * $num_per_block;
	$last_page2 = $total_page;

	//이전페이지
	$prev_page = $first_page;
	//다음 페이지
	$next_page = $last_page + 1;
	//직접 페이지
	$go_page = $first_page + 1;


	//검색할 경우
	if($searchword){
	    if($total_block <= $block){
		   $last_page=$total_page;
		 
		 }

		//이전 페이지
		
		if($block > 1){
			$page_path	=	"<li><a href=\"$go_file=$first_page2&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_all_prev.gif'></a></li>";
			$page_path .= "<li><a href=\"$go_file=$prev_page&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_prev.gif'></a></li>";

	    }

		//직접이동 페이지
		for($go_page; $go_page <= $last_page; $go_page++){
			if($page == $go_page){
				 $page_path .= "<li><font color=\"red\"><b>$go_page</b></font></li>";
			  }else{ 
				  $page_path .= "<li><a href=\"$go_file=$go_page&key=$key&searchword=$searchword\">$go_page</a></li>";
			  }
		}
		//다음 페이지
		if($block < $total_block){
	           $page_path .= "<li><a href=\"$go_file=$next_page&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_next.gif'></a></li>";
			   $page_path .= "<li><a href=\"$go_file=$last_page2&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_all_next.gif'></a></li>";
		}

	}else{

		if($total_block <= $block){
		   $last_page=$total_page;
		 
		}
	    if($block > 1){
				$page_path	=	"<li><a href=\"$go_file=$first_page2\"><img src='$page_list_url/images/board/btn_all_prev.gif'></a></li>";
	           $page_path .= "<li><a href=\"$go_file=$prev_page\"><img src='$page_list_url/images/board/btn_prev.gif'></a></li>";
		  
	    }

	    for($go_page; $go_page <= $last_page; $go_page++){
		    if($page == $go_page){
	           $page_path .= "<li><font color=\"red\"><b>$go_page</b></font></li>";
		    
			}else{
	           $page_path .= "<li><a href=\"$go_file=$go_page\">$go_page</a></li>";
		  }
	    }

	    if($block < $total_block){
	           $page_path .= "<li><a href=\"$go_file=$next_page\"><img src='$page_list_url/images/board/btn_next.gif'></a></li>";
			   $page_path .= "<li><a href=\"$go_file=$last_page2\"><img src='$page_list_url/images/board/btn_all_next.gif'></a></li>";
		}


	}
		return $page_path;
}

// 페이징
function go_page_list($query_number, $num_per_page, $num_per_block, $page, $file_name, $key, $searchword,$mode)
{
	global $page_list_url;	

	$go_file = $file_name."num_per_page=$num_per_page&mode=$mode&list_page";

	$searchword = urlencode($searchword);
	$total_page = ceil($query_number / $num_per_page);
	$total_block = ceil($total_page / $num_per_block);
	$block = ceil($page / $num_per_block);

	//첫번째 페이지
	$first_page = ($block - 1) * $num_per_block;
	$first_page2 = 1;
	$last_page = $block * $num_per_block;
	$last_page2 = $total_page;

	//이전페이지
	$prev_page = $first_page;
	//다음 페이지
	$next_page = $last_page + 1;
	//직접 페이지
	$go_page = $first_page + 1;


	//검색할 경우
	if($searchword){
	    if($total_block <= $block){
		   $last_page=$total_page;
		 
		 }

		//이전 페이지
		
		if($block > 1){
			$page_path	=	"<li><a href=\"$go_file=$first_page2&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_all_prev.gif'></a></li>";
			$page_path .= "<li><a href=\"$go_file=$prev_page&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_prev.gif'></a></li>";

	    }

		//직접이동 페이지
		for($go_page; $go_page <= $last_page; $go_page++){
			if($page == $go_page){
				 $page_path .= "<li><font color=\"red\"><b>$go_page</b></font></li>";
			  }else{ 
				  $page_path .= "<li><a href=\"$go_file=$go_page&key=$key&searchword=$searchword\">$go_page</a></li>";
			  }
		}
		//다음 페이지
		if($block < $total_block){
	           $page_path .= "<li><a href=\"$go_file=$next_page&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_next.gif'></a></li>";
			   $page_path .= "<li><a href=\"$go_file=$last_page2&key=$key&searchword=$searchword\"><img src='$page_list_url/images/board/btn_all_next.gif'></a></li>";
		}
	}else{

		if($total_block <= $block){
		   $last_page=$total_page;
		}
	    if($block > 1){
				$page_path	=	"<li><a href=\"$go_file=$first_page2\"><img src='$page_list_url/images/board/btn_all_prev.gif'></a></li>";
	           $page_path .= "<li><a href=\"$go_file=$prev_page\"><img src='$page_list_url/images/board/btn_prev.gif'></a></li>";
		  
	    }

	    for($go_page; $go_page <= $last_page; $go_page++){
		    if($page == $go_page){
	           $page_path .= "<li><font color=\"red\"><b>$go_page</b></font></li>";
		    
			}else{
	           $page_path .= "<li><a href=\"$go_file=$go_page\">$go_page</a></li>";
		  }
	    }

	    if($block < $total_block){
	           $page_path .= "<li><a href=\"$go_file=$next_page\"><img src='$page_list_url/images/board/btn_next.gif'></a></li>";
			   $page_path .= "<li><a href=\"$go_file=$last_page2\"><img src='$page_list_url/images/board/btn_all_next.gif'></a></li>";
		}
	
	}
		return $page_path;
}

// 메뉴번호를 이용해서 메뉴의 treecode를 구합니다.
function getTreeCode($sitemap, $menuIdx)
{
	$treecode = "";

	foreach ($sitemap as $siteKey => $siteVal) {
		if(is_array($siteVal)) {
			if($sitemap[$siteKey][0] == $menuIdx) {
				$treecode = $siteKey;
				break;
			}
			foreach ($sitemap[$siteKey] as $gKey => $gVal) {
				if(is_array($gVal)) {
					if($sitemap[$siteKey][$gKey][0] == $menuIdx) {
						$treecode = $gKey;
						break;
					}
					foreach ($sitemap[$siteKey][$gKey] as $mKey => $mVal) {
						if(is_array($mVal)) {
							if($sitemap[$siteKey][$gKey][$mKey][0] == $menuIdx) {
								$treecode = $mKey;
								break;
							}
						}
					}
						
					if($treecode != "") {
						break;
					}
				}
			}
				
			if($treecode != "") {
				break;
			}
		}
	}

	return $treecode;
}

// cid를 이용하여 Treecode를 구합니다.
function getTreeCode_cid($sitemap, $cid)
{
	$treecode = "";
	$cid = "cid=".$cid;
	$cidlen = strlen($cid);
	foreach ($sitemap as $siteKey => $siteVal) {
		if(is_array($siteVal)) {
			/*
			if(substr($sitemap[$siteKey][2], strlen($sitemap[$siteKey][2]) - $cidlen) == $cid) {
				$treecode = $siteKey;
				break;
			}
			*/
			foreach ($sitemap[$siteKey] as $gKey => $gVal) {
				if(is_array($gVal)) {
					if(substr($sitemap[$siteKey][$gKey][2], strlen($sitemap[$siteKey][$gKey][2]) - $cidlen) == $cid) {
						$treecode = $gKey;
						break;
					}
					foreach ($sitemap[$siteKey][$gKey] as $mKey => $mVal) {
						if(is_array($mVal)) {
							if(substr($sitemap[$siteKey][$gKey][$mKey][2], strlen($sitemap[$siteKey][$gKey][$mKey][2]) - $cidlen) == $cid) {
								$treecode = $mKey;
								break;
							}
						}
					}

					if($treecode != "") {
						break;
					}
				}
			}

			if($treecode != "") {
				break;
			}
		}
	}

	return $treecode;
}

// 쿼리스트링의 key와 val을 이용하여 treecode를 구합니다.
function getTreeCode_key_val($sitemap, $pkey, $pval)
{	
	$treecode = "";	
	foreach ($sitemap as $siteKey => $siteVal) {
		if(is_array($siteVal)) {			
			foreach ($sitemap[$siteKey] as $gKey => $gVal) {
				if(is_array($gVal)) {
					if(is_QueryString_value($sitemap[$siteKey][$gKey][2], $pkey, $pval)) {
						$treecode = $gKey;
						break;
					}
					foreach ($sitemap[$siteKey][$gKey] as $mKey => $mVal) {
						if(is_array($mVal)) {
							if(is_QueryString_value($sitemap[$siteKey][$gKey][$mKey][2], $pkey, $pval)) {
								$treecode = $mKey;
								break;
							}
						}
					}

					if($treecode != "") {
						break;
					}
				}
			}

			if($treecode != "") {
				break;
			}
		}
	}

	return $treecode;
}

// URL 문자열의 쿼리스트링에 기대하는 값이 있으면 true를 없으면 false를 반환합니다.
function is_QueryString_value($url, $ex_key, $ex_val) 
{	
	if(strpos($url, "?") === false) {
		return false;
	} else {
		$result = false;
		$querystring = explode("?", $url);
		$queryKey = explode("&", $querystring[1]);
		
		for($i = 0, $cnt = count($queryKey); $i < $cnt; $i++) {
			if(strpos($queryKey[$i], "=") === false) {
				continue;
			}
			
			$queryKeyVal = explode("=", $queryKey[$i]);
			
			if($queryKeyVal[0] == $ex_key) {
				if($queryKeyVal[1] == $ex_val) {
					$result = true;
				}
				break;
			}
		}
		
		return $result;
	}
}


function Mal_Chk($val)
{
	if($val == "1"){
		$mal = "동영상";
	}else if($val == "2"){
		$mal = "사이트";
	}else if($val == "3"){
		$mal = "결제";
	}else if($val == "4"){
		$mal = "회원정보";
	}else{
		$mal = "기타";
	}

	return $mal;
}

// 디렉토리 목록을 배열로 반환합니다.
function getDirList($path)
{
	$p = @opendir($path);
	if(!$p) {
		return null;
	}
	
	$dirList = array();
	$cnt = 0;
	while($s = readdir($p)) {
		if($s != '.' && $s != '..' && is_file($path.'/'.$s) == false) {
			$dirList[$cnt++] = $s;
		}
	}
	closedir($p);
	
	return $dirList;
}

// 파일을 씁니다.
function writeFile($path, $contents)
{
	$handle = @fopen($path, 'w');
	
	if($handle) {
		fwrite($handle, $contents);
		fclose($handle);
	}
}

// 주어진 문자열을 php 태그로 둘러싸서 반환합니다.
function getPHPTagString($str)
{
	$contents = "<?php\n";
	$contents .= "// 파일 생성 : ".date('Y-m-d H:i:s')."\n";
	$contents .= $str;
	$contents .= "?>";
	
	return $contents;
}

// HTTP_REFERER에 기대하는 URL($expected_url)이 포함되어 있지 않으면 정해진 URL($move_url)로 이동시킵니다.
// 여러개의 기대 URL을 넣으려면 |로 구분합니다.
function check_http_referer($expected_url, $move_url)
{
	$expected_array = explode("|", $expected_url);
	$result = false;
	
	foreach($expected_array as $uri) {
		if(strpos($_SERVER['HTTP_REFERER'], trim($uri)) === false) {			
		} else {
			$result = true;
			break;
		}
	}
	
	if($result == false) {
		header("Location:$move_url");
		exit;
	}
}

// $varA와 $varB가 같으면 $echoStr을 echo 합니다.
function echoCompareString($varA, $varB, $echoStr) {
	if($varA == $varB) {
		echo $echoStr;
	}
}

// 메일을 전송합니다.
function sendSimpleMail($mailTo_name, $mailTo_email, $mailFrom_name, $mailFrom_email, $subject, $message) {
	
	$mailTo = "=?UTF-8?B?".base64_encode($mailTo_name)."?="."<".$mailTo_email.">\n";
	$mailFrom = "=?UTF-8?B?".base64_encode($mailFrom_name)."?="."<".$mailFrom_email.">\n";
	$subject_ec = "=?UTF-8?B?".base64_encode($subject)."?=\n";
	
	$mailHeader = "from:{$mailFrom} \n";
	$mailHeader .= "Return-Path:{$mailFrom} \n";
	$mailHeader .= "Reply-To:{$mailFrom} \n";
	$mailHeader .= "MIME-Version: 1.0 \n";
	$mailHeader .= "Content-type: text/html; charset=utf-8\n";
	
	return mail($mailTo, $subject_ec, $message, $mailHeader);
}

// 1:1문의 구분명을 가져옵니다.
function Qna_Gubun($val)
{
	if ($val == "1") {
		$text = "개인정보관련";
	} else if ($val == "2") {
		$text = "주문/결재관련";
	} else if ($val == "3") {
		$text = "배송관련";
	} else if ($val == "4") {
		$text = "사이트 불편사항";
	} else if ($val == "5") {
		$text = "반품/환불관련";
	} else if ($val == "6") {
		$text = "기타문의";
	} else {
		$text = "기타문의";
	}
	return $text;
}

// $type에 들어있는 회원코드가 아니면 $move_uri로 이동시킵니다.
function auth_block($mtype, $type, $move_uri = "/")
{
	$result = false;
	$type_array = explode("|", $type);

	foreach($type_array as $val) {
		if($mtype == trim($val)) {
			$result = true;
			break;
		}
	}

	if($result == false) {
		header("Location: $move_uri");
		exit;
	}
}

//램덤으로 숫자 뽑아오기
function rand_no($no=6)
{
	// 영문자 O 뺌
	$arr = Array('1','2','3','4','5','6','7','8','9','0');

	for ($ii=0;$ii<$no;$ii++) {
		$num1 = rand(0,count($arr)-1);
		$num .= $arr[$num1];
	}

	return $num;
}
?>