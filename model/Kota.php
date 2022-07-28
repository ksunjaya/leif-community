<?php
class Kota{
  protected $id_kota, $nama_kota;
  public function __construct($id_kota, $nama_kota){
    $this->id_kota = $id_kota;
    $this->nama_kota = $nama_kota;
  }

  public function getIdKota(){return $this->id_kota;}

  public function getNamaKota(){return $this->nama_kota;}
}
?>