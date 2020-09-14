<?php

class Apimodel extends CI_Model
{

	function signup($postData)
	{
		$email = $postData['email'];
		$exist = $this->userExist($email);
		$result = ['code' => '404', 'status' => 'error', 'msg' => 'Erreur 404'];
		if($exist)
		{
			$result = [
				'code' => '200',
				'status' => 'error',
				'msg' => "Un utilisateur existe avec cet email."
			];
		}
		else
		{
			$sql = "INSERT INTO tbl_admin(nom,prenom,email,password,role) VALUES(?,?,?,?,?)";
			$this->db->query($sql, array($postData['nom'], $postData['prenom'], $email, $postData['password'], $postData['role'] ));
			$result = [
				'code' => '200',
				'status' => 'success',
				'msg' => 'Utilisateur créer avec succès.'
			];
		}
		return $result;
	}

	function login($postData)
	{
		$email = $postData['email'];
		$pass =   $postData['password'];
		$returnStatus = 0;

		$sql1 = "SELECT * FROM tbl_admin WHERE email=? AND  password=?";

		//run query
		$query1 = $this->db->query($sql1, array($email, $pass));

		if ($query1->num_rows() > 0) {
			$row = $query1->row();

			$returnStatus = $row->id;
		}


		return $returnStatus;
	}

	function userExist($email) 
	{
		$this->db->select('email');
		$this->db->from('tbl_admin');
		$this->db->where('email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0 )
		{
			return true;
		}
		return false;
	}

	function users()
	{

		$result = [];
		
		$sql1 = "SELECT * FROM tbl_admin";

		//run query
		$query = $this->db->query($sql1);

		if ($query->num_rows() > 0) 
		{
			$users = $query->result();
			foreach ($users as $user) 
			{
				$tmp['id'] = $user->id;
				$tmp['prenom'] = $user->prenom;
				$tmp['nom'] = $user->nom;
				$tmp['email'] = $user->email;
				$tmp['role'] = $user->role;
				$tmp['etat'] = $user->etat;
				$tmp['createdAt'] = $user->createdAt;
				array_push($result, $tmp);
			}
		}
		return $result;
	}

	function user($userId)
	{
		$query = $this->db->query("SELECT tbl_admin.id, tbl_admin.prenom, tbl_admin.nom, tbl_admin.email, tbl_admin.role, tbl_admin.etat, tbl_admin.createdAt FROM tbl_admin WHERE id=?", $userId);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}

	}
	function updateuser($userId, $data)
	{
		$this->db->where('id', $userId);
		$this->db->update('tbl_admin', $data);
        return 'success';
	}
}
