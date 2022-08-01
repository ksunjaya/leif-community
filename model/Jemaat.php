<?php
class Jemaat{
  protected $nama_lengkap, $tahun_bergabung, $jenis_kelamin, $tanggal_lahir, $telepon, $username, $photo_path, $role, $is_verified;

  public function __construct($username, $nama_lengkap, $tahun_bergabung, $jenis_kelamin, $tanggal_lahir, $tempat_lahir, $telepon, $role, $is_verified, $photo_path){
    $this->username = $username;
    $this->nama_lengkap = $nama_lengkap;
    $this->tahun_bergabung = $tahun_bergabung;
    $this->jenis_kelamin = $jenis_kelamin;
    $this->tanggal_lahir = $tanggal_lahir;
    $this->tempat_lahir = $tempat_lahir;
    $this->telepon = $telepon;
    $this->role = $role;
    $this->is_verified = $is_verified;
    $this->photo_path = $photo_path;
  }

  public function getNamaLengkap(){return $this->nama_lengkap;}

  public function getTahunBergabung(){return $this->tahun_bergabung;}

  public function getTanggalLahir(){return $this->tanggal_lahir;}

  public function getTempatLahir(){return $this->tempat_lahir;}

  public function getRole(){return $this->role;}

  public function getTelepon(){return $this->telepon;}

  public function getUsername(){return $this->username;}

  public function getVerifiedStatus(){return $this->is_verified;}

  public function getPhotoPath(){
    if(is_null($this->photo_path)) return "src/img/default_avatar.jpg";
    else return "uploads/" . $this->username . "/" . $this->photo_path;
  }
}
?>