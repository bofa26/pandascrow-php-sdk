<?php  
namespace Pandascrow\Helpers;

use Rakit\Validation\Validator;
use Pandascrow\Exception\ValidateException;
/**
 * 
 */
class Validate
{
	function __construct($logger)
	{
		$this->logger = $logger;
	}

	public function validation($data, $rules)
	{
		$validator = new Validator;
		$validation = $validator->validate($data, $rules);

		if ($validation->fails()) {
			$error = $validation->errors();
			$this->logger->log('error', $error->firstOfAll());
			throw new ValidateException($error->firstOfAll());
		}
	}
}