<?php /* Template_ 2.2.7 2013/01/14 10:25:15 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\frame_b.html 000001410 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $TPL_VAR["head_title"]?></title>
<meta name="author" content=" nanumcommunications"/>
<meta name="robots" content="all"/>
<meta name="keywords" content="<?php echo $TPL_VAR["head_keywords"]?>"/>
<meta name="description" content="<?php echo $TPL_VAR["head_description"]?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/cs/basic/css/import.css"/>
<script type="text/javascript" src="/_js/jquery.min.js"></script>
<script src="/_js/jquery.banner.js"></script>
</head>
<body>
<!-- 전체영역 -->
<div id ="wrap">
<?php $this->print_("top",$TPL_SCP,1);?>
<!-- 컨테이너 영역 시작 -->
<div id="container">
<!-- LS 컨텐츠 영역 시작 -->
<div id="s_content">
<!-- LS 우측 컨텐츠  영역 시작 -->
<?php $this->print_("content",$TPL_SCP,1);?>
<!-- LS 우측 컨텐츠  영역 끝 -->
</div>
<!-- LS 컨텐츠  영역 끝 -->
</div>
<!-- LS 컨테이너 영역 끝 -->
<?php $this->print_("foot",$TPL_SCP,1);?>
</div>
<!-- 전체 영역 끝 -->
</body>
</html>