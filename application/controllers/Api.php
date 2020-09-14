<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('session');
		$this->load->helper('url');
		$this->load->library("Server", "server");
		$this->load->database();
		$this->load->model('Apimodel');
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");
	}

	/**
	 **************************************************************************************************************
	 *												AUTH API
	 ***************************************************************************************************************
	 */

	public function signup()
	{
		if (isset($_POST["nom"]) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) 
		{
			$postData['nom'] = $_POST["nom"];
			$postData['prenom'] = $_POST["prenom"];
			$postData['email'] = $_POST["email"];
			$postData['password'] = $_POST["password"];
			$postData['role'] = $_POST["role"];
			// $postData['etat'] = 1;
			$postData['createdAt'] = date('Y-m-d H:i:s');

			$result = $this->Apimodel->signup($postData);

			header('Content-Type:application/json');
			echo trim(json_encode($result, JSON_PRETTY_PRINT));
		}
	}

	public function login()
	{
		if (isset($_POST["email"]) && isset($_POST["password"])) 
		{
			
			$postData['email'] =  $_POST["email"];
			// $postData['password'] =  md5($_POST["password"]);
			$postData['password'] =  $_POST["password"];

			if (isset($_POST["clientId"]))
				$clientId = $_POST["clientId"];

			if (isset($_POST["secret"]))
				$secret = $_POST["secret"];

			
				$client = $this->Apimodel->login($postData);
			if ($client > 0) {
		
				$ch = curl_init();

				curl_setopt_array($ch, array(
					CURLOPT_POST => 1,
					CURLOPT_HEADER => 0,
					CURLOPT_URL => base_url() . 'api/passwordCredentials',
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_USERAGENT => 'Codular Sample cURL Request',
					CURLOPT_POSTFIELDS => array(
						'grant_type' => 'password',
						'username' => $postData['email'],
						'password' => $postData['password'],
						'client_id' => $clientId,
						'client_secret' => $secret,
						'scope' => 'userinfo cloud file node'
					)
				));

				//execute post
				$result = curl_exec($ch);

				//close connection
				curl_close($ch);

				$arrResult1 = json_decode($result);


				$objResult1["status"] = "success";
				$objResult1["code"] = "200";
				$objResult1["access_token"] = $arrResult1->access_token;
				$objResult1["expires_in"] = $arrResult1->expires_in;
				$objResult1["token_type"] = $arrResult1->token_type;
				$objResult1["scope"] = $arrResult1->scope;
				$objResult1["refresh_token"] = $arrResult1->refresh_token;
				$objResult1["clientId"] = $client;

				header('Content-Type:application/json');
				echo trim(json_encode($objResult1, JSON_PRETTY_PRINT));
			} 
			else {

				$objResult["status"] = "error";
				$objResult["msg"] = "Nom d'utilisateur ou mot de passe incorrect";

				header('Content-Type:application/json');
				echo trim(json_encode($objResult, JSON_PRETTY_PRINT));
			}
		}
	}

	public function users()
	{
		$result = $this->Apimodel->users();
		header('Content-Type:application/json');
		echo trim(json_encode($result, JSON_PRETTY_PRINT));
	}

	public function user($userId)
	{
		$result = $this->Apimodel->user($userId);
		header('Content-Type:application/json');
		echo trim(json_encode($result, JSON_PRETTY_PRINT));
	}

	public function updateuser($userId)
	{
		$data = [
			'nom' => $_POST['nom'],
			'prenom' => $_POST['prenom'],
			'email' => $_POST['email'],
			'role' => $_POST['role'],
			'etat' => $_POST['status'],
		];
		if(isset($_POST['password']) && $_POST['password'] !== '')
		{
			$data['password'] = $_POST['password'];
			if($_POST['password'] !== $_POST['confirmation'])
			{
				header('Content-Type:application/json');
				echo trim(json_encode([
					'msg' => "La confirmation du mot de passe n'est pas valide.",
					'code' => '200',
					'status' => 'error'
				], JSON_PRETTY_PRINT));
				exit();
			}
		}
		$result = $this->Apimodel->updateuser($userId, $data);
		if($result === 'success') 
		{
			header('Content-Type:application/json');
			echo trim(json_encode([
				'code' => '200',
				'status' => 'success',
				'msg' => 'Utilisateur modifié avec succès.'
			], JSON_PRETTY_PRINT));
		}
		else 
		{
			header('Content-Type:application/json');
			echo trim(json_encode([
				'code' => '200',
				'status' => 'error',
				'msg' => "Erreur de modification de l'utilisateur. Veuillez réessayer ultérieurement."
			], JSON_PRETTY_PRINT));
		}
	}

	/**
	 **************************************************************************************************************
	 *												END AUTH API
	 ***************************************************************************************************************
	 */



	/**
	 * Generate token using password credentials
	 */
	public function passwordCredentials()
	{
		$this->server->password_credentials();
	}

	/**
	 * Get refresh token
	 */
	public function refreshToken()
	{
		$this->server->refresh_token();
	}

	/**
	 * Generate token using code
	 */
	public function generateToken()
	{
		$this->server->authorization_code();
	}

	//generate refresh token
	public function getrefreshtoken()
	{

		if (isset($_POST["clientId"]))
			$clientId = $_POST["clientId"];

		if (isset($_POST["secret"]))
			$secret = $_POST["secret"];

		if (isset($_POST["refreshtoken"]))
			$refreshtoken = $_POST["refreshtoken"];

		//call api to get access token
		$url = site_url('api/refreshToken');

		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'grant_type' => 'refresh_token',
				'refresh_token' => $refreshtoken,
				'client_id' => $clientId,
				'client_secret' => $secret,
				'scope' => 'userinfo',
				'state' => 'xyz',
				'redirect_uri' => site_url('api/testApi'),
				'scope' => 'userinfo'
			)
		));


		//execute post
		$result = curl_exec($ch);


		//close connection
		curl_close($ch);

		echo trim($result);
		exit;
	}

	/**
	 **************************************************************************************************************
	 *												END OF API
	 ***************************************************************************************************************
	 */
}
