<?php  
namespace Pandascrowsdk\Pandascrow\Helpers;

use Pandascrowsdk\Pandascrow\Exception\ValidateException;
/**
 * 
 */
class Validate
{
	private $bank_list = array('country' => ['alphabet', 'required']);
	private $bank_resolve = array('account_number' => ['number', 'required'], 'bank_code' => ['number', 'required']);


	private $scrow;

	function __construct($scrow)
	{
		$this->scrow = $scrow;
	}

	public function sortPathData(string $pathname, array $data)
	{

		if ($pathname === "") {
			$this->scrow->logger->log("error", "a valid Path Is Required To Sort Data");
			throw new ValidateException("A valid Path Is Required To Sort Data");
		}

		$exploded_path = explode("/", $pathname);
		$fragment = $exploded_path[1]."_".$exploded_path[2];

		if (! property_exists($this, $fragment)) {
			$this->scrow->logger->log("error", "Path Fragment Not Recognized");
			throw new ValidateException("Path Fragment Not Recognized");
		}

		$validate_error ="";

		foreach ($data as $key => $v) {
			if (! is_string($v)) {
				$validate_error = "value For Field $key Not String Type";
				break;
			}
			$v = filter_var($v, FILTER_SANITIZE_STRING):
			if (! $this->$fragment[$key]) {
				$validate_error = "$key Not Recognized";
				break;
			}
			foreach ($this->$fragment[$key] as  $rule) {
				if ($rule === "required") {
					if ($v ==="" || $v === " ") {
						$validate_error = "$key Is Required";
					}
				}

				if ($rule == "number") {
					if (preg_match("/^[0-9]$/", $v) === false) {
						$validate_error = "$key Should Be Number";
					}
				}

				if ($rule === "alphabet") {
					if (preg_match("/^[A-Za-z]/", $v) === false) {
						$validate_error = "$key Should Be Alphabet";
					}
				}
			}		
		}

		if ($validate_error != "") {
			$this->scrow->logger->log("error", $validate_error);
			throw new ValidateException($validate_error);		
		}
		return $data;
	}
}