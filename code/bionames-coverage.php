<?php

// BioNames

require_once('coverage-decade.php');

//--------------------------------------------------------------------------------------------------
$db = NewADOConnection('mysqli');
$db->Connect("localhost", 
	'root' , '' , 'ion');

// Ensure fields are (only) indexed by column name
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

$db->EXECUTE("set names 'utf8'"); 

$sql = 'SELECT COUNT(id) AS count, journal AS container, 10*FLOOR(year/10) AS decade 
		FROM names 
		WHERE journal IS NOT NULL AND year IS NOT NULL				 
		GROUP BY container, decade;';
		
		
$limit = 50;

$coverage = get_coverage_mysql($db, $sql, $limit);

file_put_contents('bionames.json', json_encode($coverage));


// add counts

$sql = 'SELECT COUNT(id) AS count
		FROM names 
		WHERE journal="<CONTAINER>" AND year IS NOT NULL				 
		AND (doi IS NOT NULL OR jstor IS NOT NULL OR handle IS NOT NULL OR url IS NOT NULL OR pdf IS NOT NULL OR cinii IS NOT NULL OR bhl IS NOT NULL OR biostor IS NOT NULL OR url IS NOT NULL OR pdf IS NOT NULL OR isbn IS NOT NULL)';				

$coverage = add_counts_mysql($db, $sql, $coverage);

print_r($coverage);

// displayImage

$html = to_html($coverage);

file_put_contents('animals.html', $html);

?>
