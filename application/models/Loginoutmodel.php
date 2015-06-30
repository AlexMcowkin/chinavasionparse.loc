<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class LoginoutModel extends CI_Model
{
	function checkuser($email, $password)
	{
		$this->db->select('email, pwd');
		$this->db->from('loginout');
		$this->db->where('email', $email);
		$this->db->where('pwd', md5('macovchin'.$password));
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
?>