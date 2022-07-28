<script type="text/javascript" src="view/assets/js/login/bootstrap.js" defer></script>
<div class="register">
  <div class="rheader">
    <h2>Selamat Datang!</h2>
    <p>Jika belum memiliki akun, kamu bisa <a href='register'>daftar disini</a>.</p>
  </div>

  <form id="registration-form" action="login" method="POST">
    <div class="form">
      <input type="text" name="username" id="username" class="form__input" autocomplete="off" placeholder=" ">
      <label for="username" class="form__label">Username</label>
    </div>

    <div class="form">
      <input type="password" name="password" id="password" class="form__input" autocomplete="off" placeholder=" ">
      <label for="password" class="form__label">Password</label>
    </div>

    <div class="form">
      <input id="form-submit" type="submit" value="Masuk">
    </div>

    <div class="form-spinner" id="form-spinner">
      <i class="fa-solid fa-compact-disc rotating"></i>
    </div>
  </form>
  <p id='reg-error'>Username atau password salah.</p>
</div>