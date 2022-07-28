<script type="text/javascript" src="view/assets/js/register/bootstrap.js" defer></script>
<div class="register">
  <div class="rheader">
    <h2>Selamat Datang!</h2>
    <p>Silahkan mengisi data diri secara lengkap dan benar pada formulir di bawah ini.</p>
  </div>

  <form id="registration-form" action="" method="POST">
    <div class="form-seperator">
      <div class="form" style="width: 70%">
        <input type="text" name="nama" id="nama" class="form__input" autocomplete="off" placeholder=" ">
        <label for="nama" class="form__label">Nama Lengkap</label>
      </div>
      <div class="form" style="width: 30%">
        <select name="jenis-kelamin" id="jenis-kelamin">
          <option value="0">L</option>
          <option value="1">P</option>
        </select>
      </div>
    </div>

    <div class="form">
      <input type="text" name="tempat-lahir" id="tempat-lahir" class="form__input" autocomplete="off" placeholder=" ">
      <label for="tempat-lahir" class="form__label">Tempat Lahir</label>
    </div>

    <div class="form-seperator">
      <div class="form" style="width: 50%">
        <input type="date" name="tanggal-lahir" id="tanggal-lahir" class="form__input" autocomplete="off" placeholder=" ">
        <label for="tanggal-lahir" class="form__label">Tanggal Lahir</label>
      </div>
      <div class="form" style="width: 50%">
        <input type="number" name="tahun-bergabung" id="tahun-bergabung" class="form__input" autocomplete="off" placeholder=" " min="2010" max="2050" value="2022">
        <label for="tahun-bergabung" class="form__label">Tahun Bergabung</label>
      </div>
    </div>
    
    <div class="form">
      <input type="tel" name="telepon" id="telepon" class="form__input" autocomplete="off" placeholder=" " maxlength="15"> 
      <label for="telepon" class="form__label">Nomor Telepon</label>
    </div>

    <div class="form">
      <input type="text" name="username" id="username" class="form__input" autocomplete="off" placeholder=" " minlength="5">
      <label for="username" class="form__label">Username</label>
    </div>
    
    <div class="form">
      <input type="password" name="password" id="password" class="form__input" autocomplete="off" placeholder=" ">
      <label for="password" class="form__label">Password</label>
    </div>

    <div class="form">
      <input type="password" id="retype-password" class="form__input" autocomplete="off" placeholder=" ">
      <label for="retype-password" class="form__label">Ketik Ulang Password</label>
    </div>

    <div class="form">
      <input id="form-submit" type="submit" value="Daftar">
    </div>
  </form>
  <p id='reg-error'>Username sudah pernah digunakan. Mohon gunakan username lainnya.</p>
  <p style="font-size: 1rem; margin-bottom: 5vh;">Sudah punya akun? Silahkan <a href="login">masuk di sini</a>.</p>
</div>