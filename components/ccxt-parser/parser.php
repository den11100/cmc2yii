<?php

	ini_set('memory_limit', '256M');
	date_default_timezone_set('Europe/Moscow');	
	include 'ccxt/ccxt.php';

    $localDbConfig = require  __DIR__ . '/../../config/db.local.php';

	DB::$settings = array(
		'hostname'	=>	'localhost',
		'username'	=>	$localDbConfig['username'],
		'password'	=>	$localDbConfig['password'],
		'db_name'	=>	'cmc2test'
	);
	
	class Parser {
		public static function update() {
			$exchanges = self::get_exchanges();
			$pairs = array();
			foreach ($exchanges as $exchange) {
				$time = time();
				$pairs = self::get_pairs($exchange);
				//print_r($pairs);
				DB::insert_items('cctx', $pairs);
			}
		}

		public static function update_tm($interval) {
			$exchanges = self::get_exchanges();

			$pairs = array();
			foreach ($exchanges as $exchange) {
			    $time = time();
				$pairs = self::get_pairs_tm($exchange, $interval);
				//print_r($pairs);
				DB::insert_items('state', $pairs);
			}
		}

		public static function get_exchanges() {
			$exchange_names = \ccxt\Exchange::$exchanges;
			$exchanges = array();
			foreach ($exchange_names as $exchange_name) {
				$exchange_class = '\ccxt\\'.$exchange_name;
				$exchange = new $exchange_class();
				$has_tickers = $exchange->has['fetchTickers'];
				if ($has_tickers) {
					array_push($exchanges, $exchange);
				}
			}
			return $exchanges;
		}

		public static function get_pairs($exchange) {
			$pairs = array();
			try {
				$tickers = $exchange->fetch_tickers();
				foreach ($tickers as $ticker) {
					array_push($pairs, array(
						'exchange'	=> $exchange->name,
						'symbol'	=> $ticker['symbol'],
						'last'		=> $ticker['last'],
						'timestamp'	=> $ticker['timestamp']
					));
				}
			} catch (Exception $exception) {
				echo 'error'."\t".$exchange->name."\n";
			}
			return $pairs;
		}

		/** @var $exchange \ccxt\Exchange */
        public static function get_pairs_tm($exchange, $tm) {
            $pairs = array();
            //try {
                $exchange->load_markets();
                //print_r($exchange);die;
                foreach ($exchange->markets as $market){
                    if (strpos($market['symbol'], '/USD') !== false){
                        $tickers = $exchange->fetchOHLCV($market['symbol'], $tm);
                        //print_r($tickers);die;
                        foreach ($tickers as $ticker) {
                            array_push($pairs, array(
                                'exchange'	=> $exchange->name,
                                'market'	=> $market['symbol'],
                                'open'		=> floatval($ticker[1]),
                                'high'		=> floatval($ticker[2]),
                                'low'		=> floatval($ticker[3]),
                                'close'		=> floatval($ticker[4]),
                                'volume'	=> floatval($ticker[5]),
                                'timestamp'	=> $ticker[0],
                                'interval'	=> $tm
                            ));
                        }
                    }
                }

            //print_r($pairs);die;
//            } catch (Exception $exception) {
////				echo 'error'."\t".$exchange->name."\n";
//            }
            return $pairs;
        }
	}
	
	class DB {
		public static $settings = array(
			'hostname'	=>	'',
			'username'	=>	'',
			'password'	=>	'',
			'db_name'	=>	''
		);
		public static $connection;
		public static function connect() {
			if (!self::$connection) {
				self::$connection = mysqli_connect(
					self::$settings['hostname'],
					self::$settings['username'],
					self::$settings['password'],
					self::$settings['db_name']
				);
				mysqli_set_charset(self::$connection, 'utf8');
			}
		}
		public static function query($query) {
			self::connect();
			$mysqli_result = mysqli_query(self::$connection, $query);
			if (is_bool($mysqli_result)) {
				$result = $mysqli_result;
			} else {
				$rows = array();
				while ($row = mysqli_fetch_assoc($mysqli_result)) {
					array_push($rows, $row);
				}
				$result = $rows;
			}

			return $result;
		}
		public static function insert_item($table_name, $item) {
			self::connect();
			foreach ($item as $key => $value) {
				$item[$key] = mysqli_real_escape_string(self::$connection, $value);
				if (is_null($value)) {
					unset($item[$key]);
				}
			}
			$fields = "`".implode("`, `", array_keys($item))."`";
			$values = "'".implode("', '", array_values($item))."'";
			$query = "INSERT INTO `$table_name` ($fields) VALUES ($values)";
			$result = DB::query($query);
			return $result;
		}
		public static function insert_items($table_name, $items) {
			foreach ($items as $item) {
                $res = self::insert_item($table_name, $item);
			}
		}
	}

?>