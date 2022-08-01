<?php
class Pelayanan{
  protected $id_pelayanan, $nama, $divisi, $photo_path;
  protected $is_taken;

  public function __construct($id_pelayanan, $nama, $divisi, $photo_path)
  {
    $this->id_pelayanan = $id_pelayanan;
    $this->nama = $nama;
    $this->divisi = $divisi;
    $this->photo_path = $photo_path;
    
    $this->is_taken = false;
  }

  public function getIdPelayanan(){return $this->id_pelayanan;}

  public function getNama(){return $this->nama;}

  public function getDivisiId(){return $this->divisi;}

  public function getPhotoPath(){return $this->photo_path;}

  public function setTaken(){
    $this->is_taken = true;
  }

  public function isTaken(){return $this->is_taken;}
}
?>