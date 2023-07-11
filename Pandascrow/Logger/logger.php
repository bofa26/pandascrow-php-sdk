<?php  
namespace Pandascrowsdk\Pandascrow\Logger;
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
	
	function __construct(string $log_path = "")
	{
		if ($log_path == "") {
			$defaultpath = dirname(dirname(__DIR__))."/Log";
			if (! is_dir($defaultpath)) {
				mkdir($defaultpath);
			}
			$path = $defaultpath."/".date("Y-m-d").'.log';
			$this->handler = fopen($path, 'a');
		}else{
			if (! is_dir($log_path)) {
				mkdir($log_path, 0777, true);
			}
			$path = $log_path."/".date("Y-m-d").".log";
			$this->handler = fopen($path, 'a');
		}
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