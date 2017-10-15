<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Default_model extends CI_Model {
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->db->query("SET time_zone='+6:00'");
	}
}
?>