<?php
	require_once("conn.php");
	// 获取请求数据
	// 方式一
	// echo $_POST["offset"]; //_POST只有form -data 能才处理
	
	// 方式二，这种方式需要序列化,接收数据格式为josn 和 raw
	$req_data = file_get_contents("php://input");
	$req_data = json_decode($req_data, true);
	
	// 方式三，HTTP_RAW_POST_DATA 需要配置参数
	// print_r( $GLOBALS['HTTP_RAW_POST_DATA'] );
	

	
	
	
	$res= tb_guojiaxian::getSubjectList();
    echo json_encode($res);