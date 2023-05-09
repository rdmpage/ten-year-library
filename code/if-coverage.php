<?php

// Index Fungorum

require_once('coverage-decade.php');

$database_filename = 'sqlite:/Users/rpage/Development/index-fungorum-coldp/if.db';

$sql = 'SELECT COUNT(id) AS count, title AS container, year/10 * 10 AS decade 
		FROM names 
		WHERE title IS NOT NULL AND year IS NOT NULL				 
		GROUP BY title, decade;';
		
$limit = 50;

$coverage = get_coverage($database_filename, $sql, $limit);

file_put_contents('if.json', json_encode($coverage));


// add counts

$sql = 'SELECT COUNT(id) AS count
		FROM names 
		WHERE title="<CONTAINER>" AND year IS NOT NULL				 
		AND (doi IS NOT NULL OR jstor IS NOT NULL OR handle IS NOT NULL OR url IS NOT NULL OR pdf IS NOT NULL OR cinii IS NOT NULL OR bhl IS NOT NULL OR biostor IS NOT NULL OR url IS NOT NULL OR pdf IS NOT NULL OR isbn IS NOT NULL)';				

$coverage = add_counts($database_filename, $sql, $coverage);

print_r($coverage);

// displayImage

$html = to_html($coverage);

file_put_contents('fungi.html', $html);

?>
