<?php
	require 'vendor/autoload.php';
	$url = $_SERVER['REDIRECT_URL'];
	$baseURL = $_SERVER['REQUEST_URI']; 
	$baseURL = dirname($baseURL);
	if($_SERVER["REQUEST_METHOD"] == "GET"){
		switch($url){
			//=========USER============
			case $baseURL.'/register':
				require_once 'controller/userController.php';
				$uc = new UserController();
				echo $uc->createRegisterView();
				break;
			case $baseURL.'/login':
				require_once 'controller/userController.php';
				$uc = new UserController();
				echo $uc->createLoginView();
				break;
			case $baseURL.'/validate-username':
				require_once 'controller/userController.php';
				$uc = new UserController();
				echo $uc->validateUsername();
				break;
			case $baseURL.'/profile':
				require_once 'controller/profileController.php';
				$pc = new ProfileController();
				echo $pc->createView();
				break;
			default:
				header("Location: not-found");
				break;
		}
	}else if($_SERVER["REQUEST_METHOD"] == "POST"){
		switch($url){
			case $baseURL.'/register':
				require_once 'controller/userController.php';
				$uc = new UserController();
				$result = $uc->registerUser();
				header('Location: profile');
				break;
			case $baseURL.'/login':
				require_once 'controller/userController.php';
				$uc = new UserController();
				$result = $uc->login();
				echo json_encode($result);
				break;
			case $baseURL.'/logout':
				require_once 'controller/userController.php';
				$uc = new UserController();
				$uc->logout();
				header('Location: login');
				break;
			case $baseURL.'/add-address':
				require_once 'controller/profileController.php';
				$pc = new ProfileController();
				$pc->addAlamat();
				header('Location: profile');
				break;
			case $baseURL.'/set-default-address':
				require_once 'controller/profileController.php';
				$pc = new ProfileController();
				$pc->setDefaultAddress();
				header('Location: profile');
				break;
			case $baseURL.'/delete-address':
				require_once 'controller/profileController.php';
				$pc = new ProfileController();
				$pc->deleteAddress();
				header('Location: profile');
				break;
			default:
				header("Location: not-found");
				break;
		}
	}
?>