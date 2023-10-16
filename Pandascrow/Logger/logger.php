<?php  
namespace Pandascrow\Logger;

use Pandascrow\Exception\AppException;
/**
 * 
 */
class Logger
{
	/**
	 * 
	 * @var string
	 * 
	 * 
	 */
	public $handler = "";
	/**
	 * 
	 * @var string
	 * 
	 * 
	 */
	public $content = "";
	
	function __construct()
	{

		if (! is_dir(LOG_PATH)) {
			throw new AppException("The Log file path is unknown");	
		}

		$path = LOG_PATH.date("Y-m-d").'.log';
		$this->handler = fopen($path, 'a');
		
	}

	public function format(string $level, string $date, string $message)
	{
		$level = strtoupper($level);
		$message = ucfirst($message);
		$fmt = sprintf("\n %s|[%s]|%s", $level, $date, $message);
		$this->content = $fmt;
	}

	public function pen()
	{
		if (! $this->handler) {
			throw new AppException("Log file missing");
		}
		fwrite($this->handler, $this->content);
	}

	public function log(string $level, string $message)
	{
		$date = date("Y-m-d H:i:s");
		$this->format($level, $date, $message);
		$this->pen();
	}
}