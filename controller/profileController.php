<?php
require_once 'services/view.php';
require_once 'services/mySQLDB.php';
require_once 'model/Kota.php';
require_once 'model/Alamat.php';
require_once 'controller/userController.php';

class ProfileController{
  private $uc;
  private $username;
  protected $db;

  public function __construct(){
    $this->db = MySQLDB::createBuilder();
    //$this->jemaat = $this->db->table('Jemaat');

    $this->uc = new UserController();
    @session_start();
    $this->username = $_SESSION['username'];
  }

  public function createView(){
    if(!$this->uc->hasLoggedIn()) header('Location: login');
    //ambil detail user
    $model = $this->uc->getCurrentUserModel();
    //ambil list nama kota
    $list_kota = $this->getListKota();
    //ambil list alamat
    $list_alamat = $this->getListAlamat($this->username);
    //ambil list pelayanan
    $list_pelayanan = $this->getPelayananList();

    return View::createView('profile.php', [
      'model' => $model,
      'list_kota' => $list_kota,
      'list_alamat' => $list_alamat,
      'list_pelayanan' => $list_pelayanan
    ]);  
  }

  public function addAlamat(){
    //$user = $this->uc->getCurrentUserModel();

    $jalan = $_POST['jalan'];
    $kode_pos = $_POST['kode-pos'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $id_kota = $_POST['id-kota'];
    
    $is_alamat_utama = 0;
    if(isset($_POST['is-alamat-utama'])) {
      $is_alamat_utama = 1;
      //set dulu semua alamat jadi 0, karena alamat utama hanya boleh satu biji
      $this->db->table('Alamat')
      ->update(['is_alamat_utama' => 0])
      ->where('username', $this->username)
      ->execute();
    }

    $query_result = $this->db->table('Alamat')->insert([
      'username' => $this->username,
      'jalan' => $jalan,
      'kode_pos' => $kode_pos,
      'kelurahan' => $kelurahan,
      'kecamatan' => $kecamatan,
      'id_kota' => $id_kota,
      'is_alamat_utama' => $is_alamat_utama
    ])->execute();
  }

  public function setDefaultAddress(){
    //$user = $this->uc->getCurrentUserModel();
    //set semua alamat jadi non default dulu
    $this->db->table('Alamat')
    ->update(['is_alamat_utama' => 0])
    ->where('username', $this->username)
    ->execute();

    //baru set satu default address
    $id_alamat = $_POST['id-alamat'];
    $this->db->table('Alamat')
    ->update(['is_alamat_utama' => 1])
    ->where('username', $this->username)
    ->where('id_alamat', $id_alamat)
    ->execute();
  }

  public function deleteAddress(){
    $id_alamat = $_POST['id-alamat'];
    $this->db->table('Alamat')
    ->delete()
    ->where('id_alamat', $id_alamat)
    ->execute();
  }

  public function updateProfile(){
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat-lahir'];
    $tanggal_lahir = $_POST['tanggal-lahir'];
    $tahun_bergabung = $_POST['tahun-bergabung'];
    $telepon = $_POST['nomor-telepon'];

    $this->db->table('Jemaat')
    ->update([
      'nama_lengkap' => $nama,
      'tempat_lahir' => $tempat_lahir,
      'tanggal_lahir' => $tanggal_lahir,
      'tahun_bergabung' => $tahun_bergabung,
      'telepon' => $telepon
    ])
    ->where('username', $this->username)
    ->execute();
  }

  public function updateProfilePicture(){
    $files = $_FILES['files'];
    $file_path = $files['tmp_name'][0]; // temporary upload path of the first file
    $file_name = $files['name'][0]; // desired name of the file
    if (!file_exists('uploads/' . $this->username)) 
      mkdir('uploads/' . $this->username, 0777, true);
    
    $save_file_path = './uploads/' . $this->username . '/' . basename($file_name);   
    move_uploaded_file($file_path, $save_file_path);
    $this->savePhotoPath(basename($file_name));

    $result = array();
    $result['url'] = $save_file_path;
    $result['whatever'] = "bip bop bip bop";
    return json_encode($result);
  }

  public function addPelayanan(){
    $id_pelayanan = $_POST['id-pelayanan'];
    //cari dulu apakah user udah pernah register pelayanan ini?
    $is_exists = $this->db->table('Pelayanan_Jemaat')->select()
    ->where('username', $this->username)
    ->where('id_pelayanan', $id_pelayanan)
    ->exists();
    if($is_exists) return;

    $this->db->table('Pelayanan_Jemaat')
    ->insert([
      'id_pelayanan' => $id_pelayanan,
      'username' => $this->username
    ])
    ->execute();
  }

  public function deletePelayanan(){
    $id_pelayanan = $_POST['id-pelayanan'];
    
    $this->db->table('Pelayanan_Jemaat')
    ->delete()
    ->where('username', $this->username)
    ->where('id_pelayanan', $id_pelayanan)
    ->execute();
  }

  private function getPelayananList(){
    require_once 'model/Pelayanan.php';
    $query_result = $this->db->table('Pelayanan as p')
    ->select(['p.id_pelayanan', 'p.nama', 'p.divisi', 'p.photo_path'])
    ->get();

    $result = array();
    for($i = 0; $i < sizeof($query_result); $i++){
      $value = $query_result[$i];
      $result[$value['id_pelayanan']] = new Pelayanan($value['id_pelayanan'], $value['nama'], $value['divisi'], $value['photo_path']);
    }

    //cari semua pelayanan yang udah diambil sama user
    $query_result = $this->db->table('Pelayanan_Jemaat as pj')
    ->select(['pj.id_pelayanan'])
    ->where('username', $this->username)
    ->get();

    //filter
    for($i = 0; $i < sizeof($query_result); $i++){
      $value = $query_result[$i];
      $result[$value['id_pelayanan']]->setTaken();
    }
    return $result;
  }

  private function savePhotoPath($path){
    $this->db->table('Jemaat')
    ->update([
      'photo_path' => $path
    ])
    ->where('username', $this->username)
    ->execute();
  }

  private function getListAlamat($username){
    $query_result = $this->db->table('Alamat as a')
    ->select([
      'a.id_alamat', 'a.jalan', 'a.kelurahan', 'a.kecamatan', 'k.nama_kota', 'a.kode_pos', 'a.is_alamat_utama'
    ])
    ->join('Kota as k', 'a.id_kota', '=', 'k.id_kota')
    ->where('a.username', $username)
    ->orderBy('a.is_alamat_utama', 'desc')
    ->get();

    $result = array();
    for($i = 0; $i < sizeof($query_result); $i++){
      $value = $query_result[$i];
      $result[] = new Alamat($value['id_alamat'], $value['jalan'], $value['kelurahan'],
      $value['kecamatan'], $value['nama_kota'], $value['kode_pos'], $value['is_alamat_utama']);
    }
    return $result;
  }

  private function getListKota(){
    $tabel_kota = $this->db->table('Kota');
    $query_result = $tabel_kota->select()->get();
    
    $result = array();
    for($i = 0; $i < sizeof($query_result); $i++){
      $result[] = new Kota($query_result[$i]['id_kota'], $query_result[$i]['nama_kota']);
    }
    return $result;
  }
}
?>