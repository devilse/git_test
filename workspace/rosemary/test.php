<?

// $dir = getcwd(); //�ش� ��ġ ���丮 �ּ� ��������
$dir = "C:/rosemary/trunk/src/rosemary/";
 

  if(is_dir($dir)){ // �ش� ���丮 ����

   if($dirop=opendir($dir)){ // ���丮 ����

    while(($filerd = readdir($dirop)) != false){ //���丮 �о����
		echo "===>".is_dir($filerd);
		if (is_dir($filerd) and $filerd != "." and $filerd != ".."){
			   echo " {$filerd} <br />";
		}
 

    }

    }} else{

			echo "���丮�� �������� ����";

    }

    closedir($dirop);

?>






