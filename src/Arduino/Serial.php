<?php

namespace Arduino;

class Serial {
	
	private $_data;
	private $_port;
	private $_baud;
	
	/**
	 * constructor
	 * @param string $port the port name, ex "com3")
	 * @param int $baud ex 9600
	 */
	public function __construct($port, $baud) {
		$this->_port = $port;
		$this->_baud = $baud;
		$this->_data = array();
	}

	/**
	 * @param int $reads number of reads (default 1)
	 * @param int $delay seconds to wait between cycle operation default 1
	 * @param $parse a parse function that will be used for each line got from the serial port
	 * @throws \Exception if is not possible read the port

	 */
	public function listen($reads = 1, $delay = 1, $parse = false) {
		
		//open read on the port
		$this->_exec();
		$fp = fopen(strtolower($this->_port), "r");
		if (!$fp) {
			throw new \Exception("Argh! I can't read the port!");
		}
		else {
			//first delay
			sleep($delay);
			//cycles of reads
			for($i=0; $i<$reads; $i++) {
			    $line = fread($fp, 8192);
			    if($parse) {
			    	$line = $parse($line);
			    }
			    //store data readed
			    if($line) {
			    	$this->_data[] = $line;
			    }
			    sleep($delay);
			}
			fclose($fp);
		}
	}
	
	/**
	 * return the data from serial
	 * @return array 
	 */
	public function getData() {
		return $this->_data;
	}
	
	/**
	 * create the pointer to the port
	 */
	private function _exec() {
		//connect to the port
		exec("mode ".strtoupper($this->_port)." BAUD=".$this->_baud." PARITY=N data=8 stop=1 xon=off");
	}
	
}