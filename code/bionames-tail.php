<?php

// Bionames

require_once('coverage-decade.php');

//--------------------------------------------------------------------------------------------------
$db = NewADOConnection('mysqli');
$db->Connect("localhost", 
	'root' , '' , 'ion');

// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$db->EXECUTE("set names 'utf8'"); 

//--------------------------------------------------------------------------------------------------

$sql = 'SELECT COUNT(id) AS count FROM names WHERE journal IS NOT NULL';		


$data = do_mysql_query($db, $sql);
$total = $data[0]->count;

$limit = 100;

$sql = 'SELECT COUNT(id) AS count, journal AS container FROM names WHERE journal IS NOT NULL GROUP BY journal ORDER BY count DESC LIMIT ' . $limit;		


$data = do_mysql_query($db, $sql);

$cumulative = 0;
foreach ($data as $row)
{
	$cumulative += $row->count;
	$row->cumulative = $cumulative;
	$row->percent = round($row->cumulative / $total * 100, 1);
	
}

//print_r($data);

echo "Publication\tCount\tCummulative\tPercent\n";
foreach ($data as $row)
{
	echo $row->container . "\t" . $row->count . "\t" . $row->cumulative . "\t" . $row->percent . "\n";
}



?>
