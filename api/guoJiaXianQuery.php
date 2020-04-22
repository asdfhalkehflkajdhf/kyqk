<?php
	require_once("conn.php");
	// 获取请求数据
	// 方式一
	// echo $_POST["offset"]; //_POST只有form -data 能才处理
	
	// 方式二，这种方式需要序列化,接收数据格式为josn 和 raw.
	//	注意：jquery ajax 直接发送的数据无法直接解析，需要前端使用JSON.stringify(postData),
	//			或是后端全用 
	//			echo json_decode(htmlspecialchars_decode($_POST['data']));
	//			PHP接收POST过的JSON格式数据，内含html实体，无法解析
	$req_data = file_get_contents("php://input");
	$req_data = json_decode($req_data, true);

	// 方式三，HTTP_RAW_POST_DATA 需要配置参数
	// print_r( $GLOBALS['HTTP_RAW_POST_DATA'] );
	function getlegendData($subject, $region, $gradeClass){
		$res=[];
		foreach($subject as $s){
			foreach ($region as $r){
				foreach($gradeClass as $gc){
					$res[]=$s.'-'.$r.'-'.$gc;
				}
			}			
		}
		return $res;
	}

	function getSeries($subject, $region, $gradeClass, $year){
		
		//获取得的值，是Series字典，
		$seriesDict=tb_guojiaxian::getRecord($subject, $region, $gradeClass, $year);
		//进行重组
		$res=[];		
		
		foreach ($seriesDict as $k=>$v){
			$item=[];
			$item["name"]=$k;
			$item["type"]="line";
			
			$x=intval(date("Y",strtotime("-{$year} year")))+1;
			$y=$v[0][1];

			for($x;$x<$y; $x++){
				$item["data"][]='null';
			}
			foreach ($v as $i){
				$item["data"][]=$i[0];
			}

			//$item["data"]=$v[0];
			$item["min"]=min($v)[0]; 
			$item["max"]=max($v)[0]; 
			$item["smooth"]=true;//平缓显示
			
			$res[]=$item;
		}
		return $res;
	}
////////////////////////////////////////////////////
	$degreeType = $req_data['degreeType'];
	$subject = $req_data['subject'];
	$region = $req_data['region'];
	$gradeClass = $req_data['gradeClass'];
	
////////////////////////////////////////////////////	
	//tb_statistics访问人次
	$res=[
		"code"=>0,
		"msg"=>"",
		"data"=>[]
	];
	
	
	$res["data"]["viewTimes"]=tb_statistics::addRecord();
	if($res["data"]["viewTimes"]==0){
		$res["data"]["viewTimes"]=tb_statistics::addRecord2();
	}
	$res["data"]["xAxisData"]=tb_guojiaxian::getYearList(10);
	$res["data"]["legendData"]=getlegendData($subject, $region, $gradeClass);
	$res["data"]["series"]=getSeries($subject, $region, $gradeClass,10);
	//$res["data"]["yAxisMinMax"]=getyAxis($subject, $region, $gradeClass);
	

    echo json_encode($res);