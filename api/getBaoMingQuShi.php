<?php
	$res = array(
		"legendData"=>array("报名数",	"报名增长率",	"录取数",	"录取增长率",	"报录比"),	
		"xAxisData"=>array(
						   1994,	1995,	1996,	1997,	1998,	1999,	2000,	
			2001,	2002,	2003,	2004,	2005,	2006,	2007,	2008,	2009,	2010,	
			2011,	2012,	2013,	2014,	2015,	2016,	2017,	2018,	2019,	2020),	
		"series"=>array(
			array("name"=>"报名数",	 "yAxisIndex"=>0,	"type"=>"bar",	"barGap"=>"-100%", 
			"label"=>array("normal"=>array("show"=>true,"position"=>'top')),//top显示数据
			"data"=>array(
												 114000,	 155000,	 204000,	 242000,	 274000,	 319000,	 392000,
			 460000,	 624000,	 797000,	 945000,	1172000,	1271200,	1282000,	1200000,	1246000,	1406000,
			1511000,	1656000,	1760000,	1720000,	1649000,	1770000,	2010000,	2380000,	2900000,	3410000)),
			
			array("name"=>"录取数",	 "yAxisIndex"=>0,	"type"=>"bar",	"barGap"=>"-100%",
			"label"=>array("normal"=>array("show"=>true,"position"=>'top')),//top显示数据
			"data"=>array(
									42000,	40000,	47000,	51000,	58000,	72000,	103000,	
			133000,	164000,	220000,	273000,	310000,	342000,	361000,	386000,	449000,	474400,	
			494600,	521300,	540900,	548700,	570600,	589800,	722200,	762500,	null,	null)),	
		
			array("name"=>"报名增长率",	 "yAxisIndex"=>1,	"type"=>"line",		
			"data"=>array(
									null,	35.96,	31.61,	18.63,	13.22,	16.42,	22.88,
			17.35,	35.65,	27.72,	18.57,	24.02,	8.46,	0.85,	-6.40,	3.83,	12.84,
			7.47,	9.60,	6.28,	-2.27,	-4.13,	7.34,	13.56,	18.41,	21.85,	17.59)),
			
			array("name"=>"录取增长率",	 "yAxisIndex"=>1,	"type"=>"line",	
			"data"=>array(
									null,	-4.76,	17.50,	8.51,	13.73,	24.14,	43.06,	
			29.13,	23.31,	34.15,	24.09,	13.55,	10.32,	5.56,	6.93,	16.32,	.66,	
			4.26,	5.40,	3.76,	1.44,	3.99,	3.36,	22.45,	5.58,	null,	null)),	
			array("name"=>"报录比",	 "yAxisIndex"=>2,	"type"=>"line",		
			"data"=>array(
									2.7 ,	3.9 ,	4.3 ,	4.7 ,	4.7 ,	4.4 ,	3.8 ,	
			3.5 ,	3.8 ,	3.6 ,	3.5 ,	3.8 ,	3.7 ,	3.6 ,	3.1 ,	2.8 ,	3.0 ,	
			3.1 ,	3.2 ,	3.3 ,	3.1 ,	2.9 ,	3.0 ,	2.8 ,	3.1 ,	null,	null))
		)
	);

	echo json_encode($res);