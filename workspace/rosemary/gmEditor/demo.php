<?
if($_POST['AAAA']==1){
	print_r($_POST);
	exit;
}
?>
<html>
<head></head>

<?
include_once('./func_editor.php');
$content = "�����Դϴ�.";
// �̹��� ���ε� ��� (1�� ������)
$upload_image = '';
// �̵�� ���ε� ��� (1�� ������)
$upload_media = '';
?>

<body>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="add_form">
<input type="HIDDEN" NAME="AAAA" value="1">

<?=myEditor(1,'.','add_form','content','100%','200');?>

<input type="button" value="�۾���" onClick="editor_wr_ok();">
</form>
</body>
</html>