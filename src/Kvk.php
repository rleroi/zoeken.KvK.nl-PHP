<?php

class Kvk {
	private static $apiUrl = 'https://zoeken.kvk.nl/JsonSearch.ashx';
	
	public static function search($query, $start = 0, $close = true) {
		if(is_array($query)) {
			if(!in_array('start', $query)) {
				$query = array_merge($query, ['start' => (int) $start]);
			}
			if(!in_array('advanced', $query)) {
				$query = array_merge($query, ['advanced' => 1]);
			}
			$httpQuery = http_build_query($query);
		} elseif(is_string($query)) {
			$httpQuery = http_build_query(['q' => $query, 'start' => (int) $start]);
		} else {
			throw new Exception('Unsupported query parameter value.');
		}
		
		// initialize cURL
		$c = curl_init(static::$apiUrl . '?'. $httpQuery);
		
		// set cURL options
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_TIMEOUT, 5);
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		
		// execute HTTP(S) request
		$data = curl_exec($c);
		
		// optionally close the connection
		if($close) {
			curl_close($c);
		}
		
		$jsonData = json_decode($data);
		
		// check if valid data
		if(!$jsonData->entries) {
			curl_close($c);
			die('error, kvk returned invalid data:<br>'.$data);
		}
		
		return $jsonData;
	}
	
	public static function searchAll($query, $limit = 0) {
		$mergedData = [];
		$start = 0;
		
		do {
			$data = static::search($query, $start, false);			
			$mergedData = array_merge($mergedData, $data->entries);
			
			// debug
			/*
			echo '<div class="alert alert-info"><strong>Info:</strong> cURL request done.<br>';
			echo 'TOTAL-RESULTS: '. $data->pageinfo->resultscount .'<br>';
			echo 'ENTRIES: '. count($data->entries) .'<br>';
			echo 'START: '. $start .'</div>';
			flush();
			ob_flush();
			*/
			
			// update new start value for next loop
			$start += $data->pageinfo->resultsperpage;
		} while($data->pageinfo->resultscount > $start && (($limit && $start < $limit) | !$limit));
		
		return $mergedData;
	}
}
