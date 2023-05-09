<?php

// Get Wikidata coverage for publications in a database, group by decade. 
// Depending on "keys" we may also add information on identifer counts

error_reporting(E_ALL ^ E_DEPRECATED);

require_once (dirname(__FILE__) . '/adodb5/adodb.inc.php');


//----------------------------------------------------------------------------------------
function do_sqlite_query($pdo, $sql)
{
	$stmt = $pdo->query($sql);

	$data = array();

	while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {

		$item = new stdclass;
		
		$keys = array_keys($row);
	
		foreach ($keys as $k)
		{
			if ($row[$k] != '')
			{
				$item->{$k} = $row[$k];
			}
		}
	
		$data[] = $item;
	
	
	}
	
	return $data;	
}

//----------------------------------------------------------------------------------------
function do_mysql_query($db, $sql)
{
	$data = array();
	
	$result = $db->Execute($sql);
	if ($result == false) die("failed [" . __FILE__ . ":" . __LINE__ . "]: " . $sql);

	while (!$result->EOF) 
	{	
		$item = new stdclass;
		
		foreach ($result->fields as $k => $v)
		{
			$item->{$k} = $v;
		}
	
		$data[] = $item;

		$result->MoveNext();
	}	
	
	return $data;	
}


//----------------------------------------------------------------------------------------
// Comparison function
function cmp($a, $b) {
	if ($a->total == $b->total) {
		return 0;
	}
	return ($a->total > $b->total) ? -1 : 1;
}

	
//----------------------------------------------------------------------------------------
// Comparison function
function decade_cmp($a, $b) {
    if ($a->max_decade == $b->max_decade) {
        return 0;
    }
    return ($a->max_decade < $b->max_decade) ? -1 : 1;
}


//----------------------------------------------------------------------------------------
function get_coverage($database_filename, $sql, $limit)
{
	$pdo =  new PDO($database_filename);
	
	$data = do_sqlite_query($pdo, $sql);

	print_r($data);

	$containers = array();

	foreach ($data as $row)
	{
		if (!isset($containers[$row->container]))
		{
			$containers[$row->container] = new stdclass;
			$containers[$row->container]->decades = array();
			$containers[$row->container]->total = 0; 	
			$containers[$row->container]->max_decade_count = 0;	
			$containers[$row->container]->max_decade = 0;	
		}
	
		$containers[$row->container]->decades[$row->decade] = $row->count;
		$containers[$row->container]->total += $row->count; // container total	
	
		// get the "modal" decade which we can use to sort on
		if ($row->count > $containers[$row->container]->max_decade_count)
		{
			$containers[$row->container]->max_decade_count 	= $row->count;
			$containers[$row->container]->max_decade 		= $row->decade;		
		}
	}

	
	// Sort publication titles by overall total of names 


	uasort($containers, 'cmp');

	// generate viz from subset of data of size "limit"

	//----------------------------------------------------------------------------------------
	// subset get decade counts

	$subset = array();
	$decades = array();

	$count = 0;

	foreach ($containers as $container_title => $container)
	{
		$subset [$container_title] = $container;

		foreach ($container->decades as $decade => $decade_count)
		{
			if (!isset($decades[$decade]))
			{
				$decades[$decade] = 0;
			}
			$decades[$decade] += $decade_count;
		}

		$count++;
	
		if ($count == $limit)
		{
			break;
		}
	}

	// sort in decadal order
	uasort($subset, 'decade_cmp');

	return $subset;
}

//----------------------------------------------------------------------------------------
function get_coverage_mysql($db, $sql, $limit)
{
	$data = do_mysql_query($db, $sql);

	print_r($data);

	$containers = array();

	foreach ($data as $row)
	{
		if (!isset($containers[$row->container]))
		{
			$containers[$row->container] = new stdclass;
			$containers[$row->container]->decades = array();
			$containers[$row->container]->total = 0; 	
			$containers[$row->container]->max_decade_count = 0;	
			$containers[$row->container]->max_decade = 0;	
		}
	
		$containers[$row->container]->decades[$row->decade] = $row->count;
		$containers[$row->container]->total += $row->count; // container total	
	
		// get the "modal" decade which we can use to sort on
		if ($row->count > $containers[$row->container]->max_decade_count)
		{
			$containers[$row->container]->max_decade_count 	= $row->count;
			$containers[$row->container]->max_decade 		= $row->decade;		
		}
	}

	
	// Sort publication titles by overall total of names 


	uasort($containers, 'cmp');

	// generate viz from subset of data of size "limit"

	//----------------------------------------------------------------------------------------
	// subset get decade counts

	$subset = array();
	$decades = array();

	$count = 0;

	foreach ($containers as $container_title => $container)
	{
		$subset [$container_title] = $container;

		foreach ($container->decades as $decade => $decade_count)
		{
			if (!isset($decades[$decade]))
			{
				$decades[$decade] = 0;
			}
			$decades[$decade] += $decade_count;
		}

		$count++;
	
		if ($count == $limit)
		{
			break;
		}
	}

	// sort in decadal order
	uasort($subset, 'decade_cmp');

	return $subset;
}



//----------------------------------------------------------------------------------------
function add_counts($database_filename, $sql, $coverage)
{
	$pdo =  new PDO($database_filename);
	
	$data = do_sqlite_query($pdo, $sql);

	foreach ($coverage as $container_title => &$container_data)
	{
		echo $container_title . "\n";
	
		$query_sql = str_replace('<CONTAINER>', str_replace('"', '""', $container_title), $sql);
	
		echo $query_sql . "\n";
	
		$data = do_sqlite_query($pdo, $query_sql);
	
		$container_data->matched = $data[0]->count;
	
	}

	return $coverage;
}

//----------------------------------------------------------------------------------------
function add_counts_mysql($db, $sql, $coverage)
{

	foreach ($coverage as $container_title => &$container_data)
	{
		echo $container_title . "\n";
	
		$query_sql = str_replace('<CONTAINER>', str_replace('"', '""', $container_title), $sql);
	
		echo $query_sql . "\n";
	
		$data = do_mysql_query($db, $query_sql);
	
		$container_data->matched = $data[0]->count;
	
	}

	return $coverage;
}


//----------------------------------------------------------------------------------------
function to_html($obj)
{
	$html = '';
	
	$html .=  '<table cellspacing="0">';

	$html .=  '<tr>';
	$html .=  '<td style="text-align:center;">Container</td>';


		for ($decade = 1750; $decade < 2030; $decade += 10)
		{
			$html .=  '<td style="border-bottom:1px solid black;">';
			$html .=  '<span style="width:20px;writing-mode:vertical-lr;">';
			$html .=  $decade . '&nbsp;';
			$html .=  '</span>';
			$html .=  '</td>';
		}
	
		// stats
		$html .=  '<td style="border-bottom:1px solid black;" halign="center">Matched</td>';


	$html .=  '</tr>';

	foreach ($obj as $container_title => $data)
	{
		$html .=  '<tr>';
		$html .=  '<td style="text-align:right;border-right:1px solid black;">';
		$html .=  $container_title . '&nbsp;';
	
		$html .=  '</td>'; 
	
		for ($decade = 1750; $decade < 2030; $decade += 10)
		{
			$html .=  '<td style="border:1px solid white;';
			
			//echo $data->decades->{$decade} . "\n";
			
			if (isset($data->decades[$decade]))
			{
				$html .=  'background-color:green;';
			
				$x = min(4, round(log10($data->decades[$decade])));
			
				$html .=  'opacity:' . $x * 0.25 . ';';
			}
			else
			{
				$html .=  'background-color:white;';
			}
		
			$html .=  '">';
		
			$html .=  '</td>';
		
	
		}
	
		// stats
		$html .=  '<td style="background-color:#EEE;border-left:1px solid black;">';
	
		if (isset($data->matched))
		{
			$percentage = round(100 * $data->matched/$data->total);
			//$html .=  $percentage;
		
			$html .=  '<div style="display:block;background-color:#999;width:' . $percentage . '%;height:1em;"></div>';
		}
		$html .=  '</td>';
		$html .=  '</tr>';
	}

	$html .=  '</table>';
	
	return $html;
}

//----------------------------------------------------------------------------------------
function number_of_names($database_filename, $sql)
{
	$pdo =  new PDO($database_filename);

	$data = do_sqlite_query($pdo, $sql);
	
	return $data[0]->count;
}

//----------------------------------------------------------------------------------------
function number_of_names_mysql($db, $sql)
{
	$data = do_mysql_query($db, $sql);
	
	return $data[0]->count;
}

//----------------------------------------------------------------------------------------
function identifier_counts($database_filename, $sql, $identifiers = array('doi'))
{
	$results = array();

	$pdo =  new PDO($database_filename);
	
	foreach ($identifiers as $identifier)
	{
		$query_sql = str_replace('<IDENTIFIER>',  $identifier, $sql);
	
		$data = do_sqlite_query($pdo, $query_sql);

		$results[$identifier] = $data[0]->count;
	
	}

	return $results;
}

//----------------------------------------------------------------------------------------
function identifier_counts_mysql($db, $sql, $identifiers = array('doi'))
{
	$results = array();

	foreach ($identifiers as $identifier)
	{
		$query_sql = str_replace('<IDENTIFIER>',  $identifier, $sql);
	
		$data = do_mysql_query($db, $query_sql);
		$results[$identifier] = $data[0]->c;
	
	}

	return $results;
}




?>
