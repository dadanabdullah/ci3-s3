<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(['form', 'url']);
	}

	public function index() {
		$this->load->view('welcome_message', ['notif' => ' ']);
	}

	public function do_upload() {

		$data['notif'] = '';
		$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
		$fileExtension = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);

		if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
			echo "Maaf, ekstensi file tidak diperbolehkan.";
		} else {
			$this->load->library('S3');

			$s3 = $this->s3->connect();
			$bucket = 'sample-bucket';
			$folder = 'sample-folder/';

			try {
				$result = $s3->putObject([
			    'Bucket' => $bucket,
			    'Key'    => $folder,
			    'Body'   => '',
				]);

				$key = $folder . uniqid() . '.' . $fileExtension;
				$body = fopen($_FILES['userfile']['tmp_name'], 'rb');
				
				try {
				  $result = $s3->putObject([
				    'Bucket' => $bucket,
				    'Key'    => $key,
				    'Body'   => $body,
				    'ACL'    => 'public-read',
				  ]);

				  $url = $result['ObjectURL'];
				  $data['notif'] = 'File berhasil diunggah ke URL: <a target="_blank" href="'.$url.'">' . $url . '</a>';
				} catch (AwsException $e) {
			    $data['notif'] = $e->getMessage();
				}
			} catch (AwsException $e) {
			    $data['notif'] = $e->getMessage();
			}
		}
		// $config['upload_path']          = './uploads/';
		// $config['allowed_types']        = 'gif|jpg|png';
		// $config['max_size']             = 100;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		// $this->load->library('upload', $config);

		// if (!$this->upload->do_upload('userfile')) {
		// 	$notif = ['notif' => $this->upload->display_errors()];
		// } else {
		// 	$notif = ['notif' => $this->upload->data()];
		// }
		$this->load->view('welcome_message', $data);
	}

}
