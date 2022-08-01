<?php
define("DEFAULT_ROLE_ID", 10);
use ClanCats\Hydrahon\Query\Sql\Func as F;
require_once 'services/view.php';
require_once 'services/mySQLDB.php';

class UserController{
  protected $db, $jemaat;
  private $model;

  public function __construct(){
    @session_start();
    $this->model = NULL;
    $this->db = MySQLDB::createBuilder();
    $this->jemaat = $this->db->table('Jemaat');
  }
  
  public function createRegisterView(){
    if($this->hasLoggedIn()) header('Location: profile');
    return View::createView('register.php', []);  
  }

  public function createLoginView(){
    if($this->hasLoggedIn()) header('Location: profile');
    return View::createView('login.php', []);
  }

  public function validateUsername(){
    $username = $_GET['u'];
    $result = $this->isUsernameRegistered($username);
    return json_encode($result);
  }

  public function registerUser(){
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis-kelamin'];
    $tempat_lahir = $_POST['tempat-lahir'];
    $tanggal_lahir = $_POST['tanggal-lahir'];
    $tahun_bergabung = $_POST['tahun-bergabung'];
    $telepon = $_POST['telepon'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $result = $this->jemaat->insert([
      'username' => $username,
      'nama_lengkap' => $nama,
      'tahun_bergabung' => $tahun_bergabung,
      'jenis_kelamin' => $jenis_kelamin,
      'tanggal_lahir' => $tanggal_lahir,
      'tempat_lahir' => $tempat_lahir,
      'tahun_bergabung' => $tahun_bergabung,
      'telepon' => $telepon,
      'password' => $hashed_password,
      'id_role' => DEFAULT_ROLE_ID, //= id jemaat di table Role.
      'is_verified' => 0
    ])->execute();

    $this->createSession($username, DEFAULT_ROLE_ID);
    return $result;
  }

  public function login(){
    $post = json_decode(file_get_contents('php://input'), true);
    $username = $post['username'];
    $password = $post['password'];

    $query_result = $this->jemaat->select('password')->where('username', $username)->get();
    if(sizeof($query_result) == 0) return false;

    if(password_verify($password, $query_result[0]['password'])){
      $this->createSession($username, $this->getUserRoleId($username));
      return true;
    }
    else return false;
  }

  public function hasLoggedIn(){
    if(isset($_SESSION['username'])) return true;
    else return false;
  }

  public function getCurrentUserModel(){
    if(!is_null($this->model) && $this->model->getUsername() == $_SESSION['username'])
      return $this->model;
    else  
      return $this->getUser($_SESSION['username']);
  }

  public function logout(){
    $this->model = NULL;
    $this->deleteSession();
  }

  public function getUserRoleId($username){
    //@assert username ada
    $query_result = $this->jemaat->select('id_role')->where('username', $username)->get();
    return $query_result[0]['id_role'];
  }

  public function getUser($username){
    $query_result = $this->db->table('Jemaat as j')
    ->select([
      'j.username', 'j.nama_lengkap', 'j.tahun_bergabung', 'j.jenis_kelamin', 'j.tanggal_lahir', 'j.tempat_lahir', 'j.telepon', 'r.name', 'j.is_verified', 'j.photo_path'
    ])
    ->join('Role as r', 'j.id_role', '=', 'r.id_role')
    ->where('j.username', $username)
    ->get();

    require_once 'model/Jemaat.php';
    return new Jemaat($query_result[0]['username'], $query_result[0]['nama_lengkap'], $query_result[0]['tahun_bergabung'], $query_result[0]['jenis_kelamin'],
    $query_result[0]['tanggal_lahir'], $query_result[0]['tempat_lahir'], $query_result[0]['telepon'], $query_result[0]['name'], $query_result[0]['is_verified'], $query_result[0]['photo_path']);
  }

  private function createSession($username, $role){
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
  }

  private function deleteSession(){
    @session_start();
    unset($_SESSION['username']);
    unset($_SESSION['role']);
  }

  private function isUsernameRegistered($username){
    $query_result = $this->jemaat->select()
    ->where('username', $username)
    ->exists();
    
    return $query_result;
  }  
}
?>