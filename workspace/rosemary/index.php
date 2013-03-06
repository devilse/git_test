<?php
// 허브 사이트가 있는지 확인하고 없으면 cs 메인으로 이동시킵니다.
// 허브 사이트 존재 유무는 옵션에서 확인합니다.

// 일단은 무조건 cs 메인으로 이동
header('Location: /web/main/index.php');
exit(); 
?>