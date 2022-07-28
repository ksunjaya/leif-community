<?php
class Alamat{
  protected $id_alamat, $jalan, $kelurahan, $kecamatan, $kota, $kode_pos, $is_alamat_utama;

  public function __construct($id_alamat, $jalan, $kelurahan, $kecamatan, $kota, $kode_pos, $is_alamat_utama){
    $this->id_alamat = $id_alamat;
    $this->jalan = $jalan;
    $this->kelurahan = $kelurahan;
    $this->kecamatan = $kecamatan;
    $this->kota = $kota;
    $this->kode_pos = $kode_pos;
    $this->is_alamat_utama = $is_alamat_utama;
  }

  public function getIdAlamat(){return $this->id_alamat;}

  public function getJalan(){return $this->jalan;}

  public function getDetail(){
    return $this->kelurahan . ', ' . $this->kecamatan . ', ' . $this->kota . '. ' . $this->kode_pos;
  }

  public function isAlamatUtama(){return $this->is_alamat_utama;}
}
?>