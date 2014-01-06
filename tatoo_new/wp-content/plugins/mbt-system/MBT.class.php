<?php
/*
	Description:	Extra added functions for ease of coding
	Class Version: 	0.4.1
	Author:			Hassan Asad
*/

if( !class_exists('MBT') ) {
	class MBT {
		
		public function genPagination( $total, $currentPage, $baseLink, $limit = 10, $showText = true, $nextPrev = true ) { 
			if( !$total || !$currentPage || !$baseLink ) { return false; }
			
			if($currentPage <= 0) { $currentPage = 1; }
			$pages_to_show = 3;
			$totalPages = ceil($total / $limit); 									//Total Number of pages 
			$txtPagesAfter = ( $totalPages == 1 ) ? " page": " pages"; 				//Text to use after number of pages 
			$txtPageList = '<br />' . $totalPages . $txtPagesAfter.' : <br />'; 	//Start off the list. 
			$min = ($currentPage - $pages_to_show < $totalPages && $currentPage - $pages_to_show > 0) ? $currentPage - $pages_to_show : 1; 
			$max = ($currentPage + $pages_to_show > $totalPages) ? $totalPages : $currentPage + $pages_to_show; 

			$pageLinks = ""; 
			for($i = $min; $i <= $max; $i++ ) { 
				if( $currentPage == $i ) { 
					//Current Page 
					$pageLinks .= '<span class="page-numbers current">'.$i.'</span>'; 
				} else { 
					$pageLinks .= '<a href="'.$baseLink.$i.'" class="page-numbers">'.$i.'</a>'; 
				}
			}
			if($nextPrev) { 
				//Next and previous links 
				$next = ($currentPage + 1 > $totalPages) ? false : '<a href="'.$baseLink.($currentPage + 1).'" class="next page-numbers">Next</a>'; 
				$prev = ($currentPage - 1 <= 0 ) ? false : '<a href="'.$baseLink.($currentPage - 1).'" class="previous page-numbers">Previous</a>'; 
			}
			if( $showText ) {
				$page_text = '<span class="displaying-num">Displaying ' . $currentPage . ' - ' . $totalPages . '</span>';
			} else {
				$page_text = null;
			}
			return '<div class="tablenav"><div class="tablenav-pages">' . $page_text.$prev.$pageLinks.$next . '</div></div>'; 
		}

		public function getBetween($str, $start, $end) {
			if ($start) {
				$startPos = strpos($str, $start);
				if ($startPos > -1) { $startPos += strlen($start); }
			}
			// End position
			if ($end) {
				$endPos = strpos($str, $end, $startPos);
			}
			if ($startPos > -1 && $endPos > -1) {
				if($end) {
					return substr($str, $startPos, $endPos - $startPos);
				} else {
					return substr($str, $startPos);
				}
			} else {
				return -1;
			}
		}
		
		public function adjustLen($title, $len, $show = '...') {
			if( strlen($title) > $len ) { return substr($title,0, ($len-2)) . $show; } else { return $title; }
		}
		
		function getExtension($str) {
			$file_chk 		= explode('.', $str);
			return $file_chk[(count($file_chk) - 1)];
		}
		
		function fixurl($url) {
			$url = str_replace('://', ':::', $url);
			$url = str_replace('//', '/', $url);
			$url = str_replace(':::', '://', $url);
			return $url;
		}
		
		// To replace only the last instance of search element
		function str_replace_last( $search, $replace, $subject ) {
			if ( !$search || !$replace || !$subject )
				return false;

			$index = strrpos( $subject, $search );
			if ( $index === false )
				return $subject;

			// Grab everything before occurence
			$pre = substr( $subject, 0, $index );

			// Grab everything after occurence
			$post = substr( $subject, $index );

			// Do the string replacement
			$post = str_replace( $search, $replace, $post );

			// Recombine and return result
			return $pre . $post;
		}
		
		// Convert Array to Object
		function array_to_object($array = array()) {
			if (!empty($array)) {
				$data = false;
				foreach ($array as $akey => $aval) {
					$data -> {$akey} = $aval;
				}
				return $data;
			}
			return false;
		}
		
		/**
		 * Executes multiple queries in a 'bulk' to achieve better
		 * performance and integrity.
		 *
		 * @param array  $data  An array of queries. Except for loaddata methods. Those require a 2 dimensional array.
		 * @param string $table
		 * @param string $method
		 * @param array  $options
		 *
		 * @return float
		 */
		public function mysqlBulk(&$data, $table, $method = 'transaction', $options = array()) {
			// Default options
			if (!isset($options['query_handler'])) {
				$options['query_handler'] = 'mysql_query';
			}
			if (!isset($options['trigger_errors'])) {
				$options['trigger_errors'] = true;
			}
			if (!isset($options['trigger_notices'])) {
				$options['trigger_notices'] = true;
			}
			if (!isset($options['eat_away'])) {
				$options['eat_away'] = false;
			}
			if (!isset($options['in_file'])) {
				$options['in_file'] = '/dev/shm/infile.txt';
			}
			if (!isset($options['link_identifier'])) {
				$options['link_identifier'] = null;
			}

			// Make options local
			extract($options);

			// Validation
			if (!is_array($data)) {
				if ($trigger_errors) { trigger_error('First argument "queries" must be an array', E_USER_ERROR);}
				return false;
			}
			if (empty($table)) {
				if ($trigger_errors) { trigger_error('No insert table specified', E_USER_ERROR);}
				return false;
			}
			if (count($data) > 10000) {
				if ($trigger_notices) {	trigger_error('It\'s recommended to use <= 10000 queries/bulk', E_USER_NOTICE); }
			}
			if (empty($data)) { return 0; }

			if (!function_exists('__exe')) {
				function __exe($sql, $query_handler, $trigger_errors, $link_identifier = null) {
					if ($link_identifier === null) {
						$x = call_user_func($query_handler, $sql);
					} else {
						$x = call_user_func($query_handler, $sql, $link_identifier);
					}
					if (!$x) {
						if ($trigger_errors) { trigger_error('Query failed.' .mysql_error() . '[sql: '.$sql.']', E_USER_ERROR);	return false; }
					}

					return true;
				}
			}

			if (!function_exists('__sql2array')) {
				function __sql2array($sql, $trigger_errors) {
					if (substr(strtoupper(trim($sql)), 0, 6) !== 'INSERT') {
						if ($trigger_errors) { trigger_error('Magic sql2array conversion only works for inserts', E_USER_ERROR); }
						return false;
					}
	
					$parts   = preg_split("/[,\(\)] ?(?=([^'|^\\\']*['|\\\']" .	"[^'|^\\\']*['|\\\'])*[^'|^\\\']" .	"*[^'|^\\\']$)/", $sql);
					$process = 'keys';
					$data  = array();

					foreach ($parts as $k=>$part) {
						$tpart = strtoupper(trim($part));
						if (substr($tpart, 0, 6) === 'INSERT') {
							continue;
						} else if (substr($tpart, 0, 6) === 'VALUES') {
							$process = 'values';
							continue;
						} else if (substr($tpart, 0, 1) === ';') {
							continue;
						}

						if (!isset($data[$process])) $data[$process] = array();
						$data[$process][] = $part;
					}

					return array_combine($data['keys'], $data['values']);
				}
			}

			// Start timer
			$start = microtime(true);
			$count = count($data);

			// Choose bulk method
			switch ($method) {
				case 'loaddata':
				case 'loaddata_unsafe':
				case 'loadsql_unsafe':
					// Inserts data only
					// Use array instead of queries

					$buf  = '';
					foreach($data as $i=>$row) {
						if ($method === 'loadsql_unsafe') {
							$row = __sql2array($row, $trigger_errors);
						}
						$buf .= implode(':::,', $row)."^^^\n";
					}

					$fields = implode(', ', array_keys($row));

					if (!@file_put_contents($in_file, $buf)) { $trigger_errors && trigger_error('Cant write to buffer file: "'.$in_file.'"', E_USER_ERROR); return false; }

					if ($method === 'loaddata_unsafe') {
						if (!__exe("SET UNIQUE_CHECKS=0", $query_handler, $trigger_errors, $link_identifier)) return false;
						if (!__exe("set foreign_key_checks=0", $query_handler, $trigger_errors, $link_identifier)) return false;
						// Only works for SUPER users:
						#if (!__exe("set sql_log_bin=0", $query_handler, $trigger_error)) return false;
						if (!__exe("set unique_checks=0", $query_handler, $trigger_errors, $link_identifier)) return false;
					}

					if (!__exe("LOAD DATA CONCURRENT LOCAL INFILE '${in_file}' INTO TABLE ${table} FIELDS TERMINATED BY ':::,'LINES TERMINATED BY '^^^\\n' (${fields})", $query_handler, $trigger_errors, $link_identifier)) return false;

				break;
				
				case 'transaction':
				case 'transaction_lock':
				case 'transaction_nokeys':
					// Max 26% gain, but good for data integrity
					if ($method == 'transaction_lock') {
						if (!__exe('SET autocommit = 0', $query_handler, $trigger_errors, $link_identifier)) return false;
						if (!__exe('LOCK TABLES '.$table.' READ', $query_handler, $trigger_errors, $link_identifier)) return false;
					} else if ($method == 'transaction_keys') {
						if (!__exe('ALTER TABLE '.$table.' DISABLE KEYS', $query_handler, $trigger_errors, $link_identifier)) return false;
					}

					if (!__exe('START TRANSACTION', $query_handler, $trigger_errors, $link_identifier)) return false;

					foreach ($data as $query) {
						if (!__exe($query, $query_handler, $trigger_errors, $link_identifier)) {
							__exe('ROLLBACK', $query_handler, $trigger_errors, $link_identifier);
							if ($method == 'transaction_lock') {
								__exe('UNLOCK TABLES '.$table.'', $query_handler, $trigger_errors, $link_identifier);
							}
							return false;
						}	
					}

					__exe('COMMIT', $query_handler, $trigger_errors, $link_identifier);

					if ($method == 'transaction_lock') {
						if (!__exe('UNLOCK TABLES', $query_handler, $trigger_errors, $link_identifier)) return false;
					} else if ($method == 'transaction_keys') {
						if (!__exe('ALTER TABLE '.$table.' ENABLE KEYS', $query_handler, $trigger_errors, $link_identifier)) return false;
					}
				break;
				
				case 'none':
					foreach ($data as $query) {
						if (!__exe($query, $query_handler, $trigger_errors, $link_identifier)) return false;
					}

				break;
				
				case 'delayed':
					// MyISAM, MEMORY, ARCHIVE, and BLACKHOLE tables only!
					if ($trigger_errors) { trigger_error('Not yet implemented: "'.$method.'"', E_USER_ERROR); }
				break;
				
				case 'concatenation':
				case 'concat_trans':
					// Unknown bulk method
					if ($trigger_errors) { trigger_error('Deprecated bulk method: "'.$method.'"', E_USER_ERROR); }
					return false;
				break;
				
				default:
					// Unknown bulk method
					if ($trigger_errors) { trigger_error('Unknown bulk method: "'.$method.'"', E_USER_ERROR); }
					return false;
				break;
			}

			// Stop timer
			$duration = microtime(true) - $start;
			$qps    = round ($count / $duration, 2);

			if ($eat_away) { $data = array(); }

			@unlink($options['in_file']);

			// Return queries per second
			return $qps;
		}
		
		function jsRedirect($url) {
			echo '
				<script type="text/javascript">
					window.location = \'' . $url . '\';
				</script>
			';
		}
		function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
		/*
		$interval can be:
		yyyy - Number of full years
		q - Number of full quarters
		m - Number of full months
		y - Difference between day numbers
			(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
		d - Number of full days
		w - Number of full weekdays
		ww - Number of full weeks
		h - Number of full hours
		n - Number of full minutes
		s - Number of full seconds (default)
		*/
		
		if (!$using_timestamps) {
			$datefrom = strtotime($datefrom, 0);
			$dateto = strtotime($dateto, 0);
		}
		$difference = $dateto - $datefrom; // Difference in seconds
		 
		switch($interval) {
		 
		case 'yyyy': // Number of full years
	
			$years_difference = floor($difference / 31536000);
			if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
				$years_difference--;
			}
			if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
				$years_difference++;
			}
			$datediff = $years_difference;
			break;
	
		case "q": // Number of full quarters
	
			$quarters_difference = floor($difference / 8035200);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$quarters_difference--;
			$datediff = $quarters_difference;
			break;
	
		case "m": // Number of full months
	
			$months_difference = floor($difference / 2678400);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$months_difference--;
			$datediff = $months_difference;
			break;
	
		case 'y': // Difference between day numbers
	
			$datediff = date("z", $dateto) - date("z", $datefrom);
			break;
	
		case "d": // Number of full days
	
			$datediff = floor($difference / 86400);
			break;
	
		case "w": // Number of full weekdays
	
			$days_difference = floor($difference / 86400);
			$weeks_difference = floor($days_difference / 7); // Complete weeks
			$first_day = date("w", $datefrom);
			$days_remainder = floor($days_difference % 7);
			$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
			if ($odd_days > 7) { // Sunday
				$days_remainder--;
			}
			if ($odd_days > 6) { // Saturday
				$days_remainder--;
			}
			$datediff = ($weeks_difference * 5) + $days_remainder;
			break;
	
		case "ww": // Number of full weeks
	
			$datediff = floor($difference / 604800);
			break;
	
		case "h": // Number of full hours
	
			$datediff = floor($difference / 3600);
			break;
	
		case "n": // Number of full minutes
	
			$datediff = floor($difference / 60);
			break;
	
		default: // Number of full seconds (default)
	
			$datediff = $difference;
			break;
		}    
	
		return $datediff;
	
	}

	}
	
}
?>