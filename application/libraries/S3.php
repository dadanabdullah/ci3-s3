<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require 'aws/aws-autoloader.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3 {

	function __construct()
	{
		$this->CI = & get_instance();
	}

	public function connect()
	{
		$this->CI->config->load('s3');

		$s3client = new S3Client([
		  'version' => $this->CI->config->item('s3_version'),
		  'region' => $this->CI->config->item('s3_region'),
		  'credentials' => [
		    'key' => $this->CI->config->item('s3_key'),
		    'secret' => $this->CI->config->item('s3_secret'),
		  ],
		  'endpoint' => $this->CI->config->item('s3_endpoint')
		]);

		return $s3client;
	}

}

/* End of file S3.php */
/* Location: ./application/libraries/S3.php */
