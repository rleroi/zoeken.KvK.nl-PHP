<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
try {
	require_once('Kvk.php');

	@$query = urldecode($_GET['q']) ?: '';
	@$limit = urldecode((int) $_GET['limit']) ?: 0;
	
	$data = Kvk::searchAll($query, $limit);
	
	echo '<div class="alert alert-light">Search results for \'<strong>'.htmlspecialchars($query).'</strong>\'</div>';
	
	/*
		// get all 'handelsnamen'
		$bedrijven = array_map(function($value) {return $value->handelsnaam;}, $data);
		echo implode(', ', $bedrijven);
	*/
	
	foreach($data as $bedrijf) {
		@echo "<strong>{$bedrijf->handelsnaam}</strong> <small>{$bedrijf->straat} {$bedrijf->huisnummer}{$bedrijf->huisnummertoevoeging}, {$bedrijf->postcode} {$bedrijf->plaats}</small> <span class=\"badge badge-secondary\">KVK {$bedrijf->dossiernummer}</span><br>";
	}
	
	echo '<div class="alert alert-light">Total '.count($data).' results</div>';
	
} catch (PDOException $e) {
	echo '<div class="alert alert-danger"><strong>Error:</strong> '.$e->getMessage().'</div>';
} catch (Exception $e) {
	echo '<div class="alert alert-danger"><strong>Error:</strong> '.$e->getMessage().'</div>';
}

?>
</div>
</body>
</html>