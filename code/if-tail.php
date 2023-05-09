<?php

// Index Fungorum

require_once('coverage-decade.php');

$database_filename = 'sqlite:/Users/rpage/Development/index-fungorum-coldp/if.db';
$pdo =  new PDO($database_filename);


$sql = 'SELECT COUNT(id) AS count FROM names WHERE title IS NOT NULL and title <> ""';		

$data = do_sqlite_query($pdo, $sql);
$total = $data[0]->count;

$limit = 100;

$sql = 'SELECT COUNT(id) AS count, title AS container FROM names WHERE title IS NOT NULL GROUP BY title ORDER BY count DESC LIMIT ' . $limit;		
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
