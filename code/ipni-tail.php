<?php

// IPNI

require_once('coverage-decade.php');

$database_filename = 'sqlite:/Users/rpage/Development/ipni-coldp/ipni.db';
$pdo =  new PDO($database_filename);

$sql = 'SELECT COUNT(id) AS count FROM names WHERE publication IS NOT NULL and publication <> ""';		

$data = do_sqlite_query($pdo, $sql);
$total = $data[0]->count;

$limit = 100;

$sql = 'SELECT COUNT(id) AS count, publication AS container FROM names WHERE publication IS NOT NULL and publication != "" GROUP BY publication ORDER BY count DESC LIMIT ' . $limit;		


$data = do_sqlite_query($pdo, $sql);

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
