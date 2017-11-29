<?php
namespace Core\library;

class Log {
	private $handle;

	public function __construct($param) {

	}
	public function open($filename) {
		$this->handle = fopen(DIR_LOGS . $filename, 'a');
	}

	public function write($filename,$message) {
		$this->open($filename);
		fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
	}

	public function __destruct() {
		fclose($this->handle);
	}
}