<?php

// Index Fungorum

require_once('coverage-decade.php');

$database_filename = 'sqlite:/Users/rpage/Development/ipni-coldp/ipni.db';

$sql = 'SELECT COUNT(id) AS count FROM names';		

$num = number_of_names($database_filename, $sql);

echo "Number of names=$num\n";


$sql = 'SELECT COUNT(id) AS count FROM names WHERE <IDENTIFIER> IS NOT NULL';		

$identifiers = array('doi', 'handle', 'jstor', 'biostor', 'bhl', 'url', 'pdf', 'wikidata');

$results = identifier_counts($database_filename, $sql, $identifiers);


print_r($results);


?>
