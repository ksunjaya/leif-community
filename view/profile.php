<script type="text/javascript" src="view/assets/js/vendor/jquery.leanModal.min.js"></script>
<script type="text/javascript" src="view/assets/js/vendor/animatedModal.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('a[rel*=leanModal]').leanModal({ top : 50, closeButton: ".modal-close" });		
    $("#edit-profile").animatedModal({
      animatedIn: 'zoomIn',
      animatedOut: 'bounceOut',
      color: '#FFF'
    });
  });
</script>

<div class="container">
  <nav>
    <a href="#" class="nav-link-mobile" id="show-menu">
      <i class="fa-solid fa-bars"></i>
    </a>
    <!-- <img src="src/img/logo.png"> -->
    <p>LEIF COMMUNITY</p>
    <a href="#" class="nav-link-mobile">
      <i class="fa-solid fa-bell"></i>
      <span class="button-badge">2</span>
    </a>
  </nav>
  
  <div id="sidebar">    
    <ul class="sidebar-nav">
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fa-solid fa-user-astronaut"></i>
          <span class="link-text">Profile</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fa-solid fa-calendar"></i>
          <span class="link-text">Events</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fa-solid fa-user"></i>
          <span class="link-text">Profil</span>
        </a>
      </li>
    </ul>
  </div>

  <main>
    <?php if($model->getVerifiedStatus() == 0){?>
    <div class="reg-status">
      <h2>Akun Belum Tervalidasi</h2>
      <p>Saat ini akun kamu belum tervalidasi oleh tim kami. Harap melengkapi profil kamu secepat mungkin.</p>
    </div>
    <?php }?>

    <div class="main-content">
      <a href="#picture-modal" rel="leanModal">
        <img src="<?php echo $model->getPhotoPath();?>" alt="Avatar" id="avatar">
      </a>
      <div>
        <p id="name"><?php echo $model->getNamaLengkap();?></p>
        <p id="division"><?php echo $model->getRole();?></p>
        <a href="#profile-modal" id="edit-profile" class="a-blue-button"><i class="fa-solid fa-pen-to-square"></i>Ubah Profil</a>
      </div>
    </div>
  </main>

  <div id="content2">
    <h2>Minat Pelayanan</h2>
    
    <div class="pelayanan-card-container">
      <?php 
        foreach($list_pelayanan as $pelayanan){
          if($pelayanan->isTaken()){
            echo("
            <div class='pelayanan-card' style='background-image: url(\"src/img/pelayanan/". $pelayanan->getPhotoPath()."\")'>
              <p>". $pelayanan->getNama()."</p>
              <form action='delete-pelayanan' method='POST'>
                <input type='hidden' name='id-pelayanan' value='". $pelayanan->getIdPelayanan() ."'>
                <input type='submit' value='Hapus'>
              </form>
            </div>
            ");
          }
        }
      ?>

      <a href="#pelayanan-modal" rel="leanModal"><div class="pelayanan-card">
        <i class="fa-solid fa-plus"></i>
      </div></a>
    </div>
  </div>

  <div id="content1">
    <h2>Daftar Alamat</h2>
    <?php
      $counter = 1;
      foreach($list_alamat as $alamat){
        $header_text = ($counter == 1)? 'Alamat Utama' : 'Alamat #'.$counter;
        $delete_button = '
        <form action="delete-address" method="POST">
        <input type="hidden" name="id-alamat" value="'.$alamat->getIdAlamat().'">
        <input class="submit-material-theme red no-border" type="submit" value="Hapus">
        </form>
        ';
        $alamat_utama_button = ($counter == 1)? '' : 
        '<form action="set-default-address" method="POST">
          <input type="hidden" name="id-alamat" value="'.$alamat->getIdAlamat().'">
          <input class="submit-material-theme green" type="submit" value="Jadikan Alamat Utama">
        </form>';
        $counter++;

        echo '
        <div class="address-card">
          <div class="address-title">
            <h3>'. $header_text .'</h3>
            '. $delete_button .'
          </div>
          <p>'. $alamat->getJalan() .'</p>
          <p id="address-detail">'. $alamat->getDetail() .'</p>
          '. $alamat_utama_button .'
        </div>
        ';
      }
    ?>

    <a href="#add-address" class="a-blue-button" rel="leanModal"><i class="fa-solid fa-plus"></i>Tambah Alamat Baru</a>
  </div>

  <div id="content3">
    CONTENT3
  </div>

  <footer>
    <form action="logout" method="POST">
      <input type="submit" value="Keluar Akun">
    </form>
    <p style="margin: 1rem"><i class="fa-solid fa-copyright"></i> 2022 Leif Community.<br>Keep Spirit, Keep Praying, and All For Jesus.</p>
  </footer>
</div>

<!--Add Address Modal Profile-->
<div id="add-address">
  <div class="modal-header">
    <h2>Tambah Alamat Baru</h2>
    <a class="modal-close" href="#"><i class="fa-solid fa-xmark"></i></a>
  </div>
  <div class="modal-content">
    <form action="add-address" method="POST">
      <div class="form-seperator">
        <div class="form" style="width: 70%">
          <input type="text" name="jalan" id="jalan" class="form__input" autocomplete="off" placeholder=" " required>
          <label for="jalan" class="form__label">Nama Jalan</label>
        </div>

        <div class="form" style="width: 30%">
          <input type="tel" name="kode-pos" id="kode-pos" class="form__input" autocomplete="off" placeholder=" " required>
          <label for="kode-pos" class="form__label">Pos</label>
        </div>
      </div>

      <div class="form-seperator">
        <div class="form" style="width: 50%">
          <input type="text" name="kelurahan" id="kelurahan" class="form__input" autocomplete="off" placeholder=" " required>
          <label for="kelurahan" class="form__label">Kelurahan</label>
        </div>

        <div class="form" style="width: 50%">
          <input type="text" name="kecamatan" id="kecamatan" class="form__input" autocomplete="off" placeholder=" " required>
          <label for="kecamatan" class="form__label">Kecamatan</label>
        </div>
      </div>

      <div class="form">
        <select name="id-kota" id="id-kota">
          <?php
            foreach($list_kota as $kota){
              echo '<option value="'.$kota->getIdKota().'">'.$kota->getNamaKota().'</option>';
            }
          ?>
        </select>
      </div>

      <span>    
        <input type="checkbox" id="is-alamat-utama" name="is-alamat-utama" <?php if(sizeof($list_alamat) == 0) echo 'checked onclick="return false;"';?>>
        <label for="is-alamat-utama">Jadikan alamat utama.</label>
      </span>

      <div class="form">
        <input id="form-submit" type="submit" value="Tambah Alamat">
      </div>
    </form>
  </div>
</div>
<div id="lean_overlay" style="display: none; opacity: 0.5;"></div>


<!--Edit Profile-->
<div id="profile-modal">
  <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
  <div class="close-profile-modal"> 
    <i class="fa-solid fa-angle-left"></i>
  </div>
      
  <div class="profile-modal-content">
    <h2>Ubah Profil Pribadi</h2>
    <form id="profile-edit-form" action="update-profile" method="POST">
      <div class="form">
        <input type="text" name="nama" id="nama" class="form__input" autocomplete="off" placeholder=" " value="<?php echo $model->getNamaLengkap();?>" required>
        <label for="nama" class="form__label">Nama Lengkap</label>
      </div>

      <div class="form">
        <input type="text" name="tempat-lahir" id="tempat-lahir" class="form__input" autocomplete="off" placeholder=" " value="<?php echo $model->getTempatLahir();?>" required>
        <label for="tempat-lahir" class="form__label">Tempat Lahir</label>
      </div>

      <div class="form-seperator">
        <div class="form" style="width: 50%">
          <input type="date" name="tanggal-lahir" id="tanggal-lahir" class="form__input" autocomplete="off" placeholder=" " value="<?php echo $model->getTanggalLahir();?>" required>
          <label for="tanggal-lahir" class="form__label">Tanggal Lahir</label>
        </div>
        <div class="form" style="width: 50%">
          <input type="number" name="tahun-bergabung" id="tahun-bergabung" class="form__input" autocomplete="off" placeholder=" " min="2010" max="2050" value="<?php echo $model->getTahunBergabung();?>" required>
          <label for="tahun-bergabung" class="form__label">Tahun Bergabung</label>
        </div>
      </div>
      
      <div class="form">
        <input type="tel" name="telepon" id="telepon" class="form__input" autocomplete="off" placeholder=" " maxlength="15" value="<?php echo $model->getTelepon();?>"> 
        <label for="telepon" class="form__label">Nomor Telepon</label>
      </div>

      <div class="form">
        <input id="form-submit" type="submit" value="Ubah Profil">
      </div>

      <div class="form">
        <p style="font-size: 0.7rem; color: black; text-align:center;">*Perubahan profil akan membutuhkan verifikasi ulang dari tim kami. Beberapa fitur mungkin tidak dapat diakses hingga proses verifikasi selesai.</p>
      </div>
      </form>
  </div>
</div>

<!--Edit Profile Picture-->
<div id="picture-modal">
  <div class="modal-header">
    <h2>Ubah Foto Profil</h2>
    <a class="modal-close" href="#"><i class="fa-solid fa-xmark"></i></a>
  </div>
  <div class="modal-content">
    <!-- <div id="drag-drop-area"></div> -->
    <div class="Uppy">
      <form action="https://xhr-server.herokuapp.com/upload" method="post">
        <h5>Uppy was not loaded ??? slow connection, unsupported browser, weird JS error on a page ??? but the upload still works, because HTML is cool like that</h5>
        <input type="file" name="files[]" multiple="">
        <button type="submit">Fallback Form Upload</button>
      </form>
    </div>
  </div>
</div>

<!-- Add Pelayanan -->
<div id="pelayanan-modal">
<div class="modal-header">
    <h2>Tambah Pelayanan</h2>
    <a class="modal-close" href="#"><i class="fa-solid fa-xmark"></i></a>
  </div>
  <div class="modal-content">
    <form action="add-pelayanan" method="POST">
      <div class="form">
        <select name="id-pelayanan">
        <?php 
        foreach($list_pelayanan as $pelayanan){
          if($pelayanan->isTaken()) continue;
          echo('<option value="'. $pelayanan->getIdPelayanan() .'">'. $pelayanan->getNama() .'</option>');
        }
        ?>
        </select>
      </div>
      <input type="submit" value="Tambah Pelayanan" class="a-blue-button">
    </form>
  </div>
</div>

<script src="https://releases.transloadit.com/uppy/v2.13.1/uppy.min.js"></script>
<script type="text/javascript" src="view/assets/js/profile/bootstrap.js" defer></script>
<!-- Mungkin ini akan dijadikan global -->
<script>
  const btnShowMenu = document.getElementById('show-menu');
  const sidebar = document.getElementById('sidebar');

  var isSidebarShown = false;
  
  btnShowMenu.addEventListener('click', function(e){
    e.preventDefault();
    if(isSidebarShown) {
      sidebar.style.display = 'none';
      btnShowMenu.firstElementChild.className = "fa-solid fa-bars"
    }else{
      sidebar.style.display = 'block';
      btnShowMenu.firstElementChild.className = "fa-solid fa-minus"
    }
    isSidebarShown = !isSidebarShown;
  });
</script>