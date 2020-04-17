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

	function getRecord($subject, $region, $gradeClass){
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
		
		$condition = implode(' and ',$condition);
		
		$sql = "SELECT * from tb_guojiaxian where {$condition} order by year";
		
		$res=[];
		
		foreach ($conn->query($sql) as $row) {
			//$item=[];
			$name = $row['subject'].'-'.$row['region'].'-'.$row['grade_class'];
			$res[$name][]=intval($row['grade']);
		}
		return $res;
	}
	
	
	
	function getYearList(){
		//打开数据库
		//subject, region, grade_class, year, grade, degree_type
		$conn =new connent_db();
		
		$sql = "SELECT year from tb_guojiaxian group by year order by year";
		
		$res=[];
		
		foreach ($conn->query($sql) as $row) {
			//$item=[];
			$res[]=$row['year'];
			
			//$res[$row['degree_type']][]=array('subject'=>$row['subject']);
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
		$ip_addr = $_SERVER['REMOTE_ADDR'];//当前用户 IP 。 
		$conn =new connent_db();
		
		$sql = "insert into tb_statistics (ipaddr, datetime)values('{$ip_addr}', datetime('now'));";

		return $conn->lastInsertId();
	}
	function addRecord2(){
		//PDO insert 有问题，不研究了
		class MyDB extends SQLite3{
			function __construct(){
			   $this->open('kaoyanqingkuang.db');
			}
		}
		$db = new MyDB();
		if(!$db){
			echo $db->lastErrorMsg();
		} else {
			echo "Opened database successfully\n";
		}
		$ip_addr = $_SERVER['REMOTE_ADDR'];//当前用户 IP 。 
		$sql = "insert into tb_statistics (ipaddr, datetime)values('{$ip_addr}', datetime('now'));";

		$ret = $db->exec($sql);
		if(!$ret){
			echo $db->lastErrorMsg();
		} else {
			echo $db->changes(), " Record deleted successfully\n";
		}
		
		$res = $db->lastInsertRowID();
		$db->close();
		return $res;
	}	


}

