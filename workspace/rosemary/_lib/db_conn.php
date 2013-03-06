<?php
 define(DB_HOST, 'localhost');// Define uma constante.
 define(DB_USER, 'rosemary');
 define(DB_PW, 'rosemary');


function DB_CONN($host,$retry=1)
{
		$user = "rosemary";
		$pass = "rosemary";

		if(!$host) $host = "localhost";	
		switch($host)
		{
			case "localhost":	
				$server="localhost";
			break;
			case "rosemary":
				$user = "rosemary";
				$pass = "rosemary";
				$db = "rosemary";
				$server = "192.168.0.221";
			break;

			default:$server="localhost";
		}
		

		$again=1;
		do {

				//$result = @mysqli_connect($server,DB_USER,DB_PW);
				$result = @mysqli_connect($server,$user,$pass,$db, "3306");
				if ($result) break;
				if ($retry == $again) break;
				$again++;
				usleep(10000);
		}while(1);

		return $result;
}


function sql_query($db, $sql, $error=TRUE)
{
	if ($error){
		$result = @mysqli_query($db,$sql) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER[PHP_SELF]");
	}else{
		$result = @mysqli_query($db,$sql);
	}
	return $result;
}

function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}

// 결과의 첫번째 행의 첫번째 컬럼의 값을 반환합니다. DB에서 단일값을 가져올 때 사용.
function mysqli_scalar($query) 
{	
	global $CONN;
	$query_result = sql_query($CONN['rosemary'], $query, false);
	if($query_result) {
		return mysqli_result($query_result, 0, 0);
	}
	else
	{
		return null;
	}
}

$CONN['rosemary']  =	 DB_CONN('rosemary');		
if (!$CONN['rosemary']) {
	alert("디비 접속 안됨");
}
//@mysqli_select_db("rosemary");


?>