<?php
/*****************************
*数据库连接
*****************************/


class connent_db extends PDO {

	function __construct(){
		parent::__construct("sqlite:kaoyanqingkuang.db");

	}
	function __destruct(){
	}
}



/*****************************
*数据库操作
*****************************/
final class tb_guojiaxian{

	function getRecord($subject, $region, $gradeClass, $year){
		//打开数据库
		//subject, region, grade_class, year, grade, degree_type
		function change_to_quotes($str) {
			return sprintf("'%s'", $str);
		};
		$condition=[];

		$conn =new connent_db();
		
		$condition[] =  "subject in(".implode(',', array_map('change_to_quotes', $subject )).')';
		$condition[] =  "region in(".implode(',', array_map('change_to_quotes', $region )).')';
		$condition[] =  "grade_class in(".implode(',', array_map('change_to_quotes', $gradeClass )).')';
		$condition[] =  "grade_class in(".implode(',', array_map('change_to_quotes', $gradeClass )).')';
		$condition[] =  "year > ".date("Y",strtotime("-{$year} year"));
		$condition = implode(' and ',$condition);
		
		$sql = "SELECT * from tb_guojiaxian where {$condition} order by year";
		//echo $sql;
		$res=[];
		foreach ($conn->query($sql) as $row) {
			//$item=[];
			$name = $row['subject'].'-'.$row['region'].'-'.$row['grade_class'];
			$res[$name][]=array(intval($row['grade']), intval($row['year']));

		}
		return $res;
	}
	
	
	
	function getYearList($year){
		//打开数据库
		//subject, region, grade_class, year, grade, degree_type
		/*
		$conn =new connent_db();
		
		$sql = "SELECT year from tb_guojiaxian group by year order by year";
		
		$res=[];
		
		foreach ($conn->query($sql) as $row) {
			//$item=[];
			$res[]=$row['year'];
			
			//$res[$row['degree_type']][]=array('subject'=>$row['subject']);
		}
		*/
		////////////////////////////////////////
		$res=[];
		$x=intval(date("Y",strtotime("-{$year} year")))+1;
		$y=intval(date("Y"));
		for($x;$x<=$y;$x++){
			$res[]=$x;
		}
		return $res;
	}	
	
	
	function getSubjectList(){
		//打开数据库
		//subject, region, grade_class, year, grade, degree_type
		$conn =new connent_db();
		
		$sql = "select subject, degree_type from tb_guojiaxian GROUP BY subject";
		
		$res=[];
		
		foreach ($conn->query($sql) as $row) {
			//$item=[];
			$res[$row['degree_type']][]=$row['subject'];
			
			//$res[$row['degree_type']][]=array('subject'=>$row['subject']);
		}
		
		return $res;
	}
	

}
final class tb_statistics{

	function addRecord(){
		//PDO insert 有问题，不研究了
		$db = new SQLite3('statistics.db');

		if(!$db){
			echo $db->lastErrorMsg();
		} else {
			//echo "Opened database successfully\n";
			$sql = "CREATE TABLE  IF NOT EXISTS tb_statistics (
			id       INTEGER  PRIMARY KEY AUTOINCREMENT,
			ipaddr   VARCHAR,
			datetime DATETIME
			);";
			$ret = $db->exec($sql);
		}
		$ip_addr = $_SERVER['REMOTE_ADDR'];//当前用户 IP 。 
		$sql = "insert into tb_statistics (ipaddr, datetime)values('{$ip_addr}', datetime('now'));";

		$ret = $db->exec($sql);
		if(!$ret){
			echo $db->lastErrorMsg();
		} else {
			//echo $db->changes(), " Record deleted successfully\n";
		}
		
		$res = $db->lastInsertRowID();
		$db->close();
		return $res;
	}	


}

