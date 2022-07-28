const btnSubmit = document.getElementById('form-submit');
const iPassword = document.getElementById('password');
const iRetypePassword = document.getElementById('retype-password');
const iUsername = document.getElementById('username');
const spanError = document.getElementById('reg-error');
const form = btnSubmit.parentNode.parentNode;

function init(){
  btnSubmit.addEventListener('click', function(e){
    spanError.style.visibility = 'hidden';
    e.preventDefault();
    if(isFormFilled()){
      if(isPasswordMatched()){
        if(iUsername.value.length < 5){
          spanError.innerHTML = 'Username kamu terlalu singkat (minimal 5 huruf).';
          spanError.style.visibility = 'visible';
          iUsername.style.borderColor = '#ffcc00';
          return;
        }
        //cek validitas username
        fetch('validate-username?u='+iUsername.value)
        .then(function(response){
          return response.json();
        }).then(function(json){
          if(json == true){
            spanError.innerHTML = 'Username sudah pernah digunakan. Mohon gunakan username lainnya.';
            spanError.style.visibility = 'visible';
            iUsername.style.borderColor = '#ffcc00';
          }else{
            //submit form
            form.submit();
          }
        });
      }else{
        iPassword.style.borderColor = '#ffcc00';
        iRetypePassword.style.borderColor = '#ffcc00';
      }
    }
  });
}

function isUsernameRegistered(username){
  
}

function isFormFilled(){
  let filled = true;
  for (var i = 0, element; element = form.elements[i++];) {
    if (element.value === ""){
      element.style.borderColor = "red";
      filled = false;
    }else{
      element.style.borderColor = "#e1e5ee";
    }
  }
  return filled;
}

function isPasswordMatched(){
  return iPassword.value === iRetypePassword.value;
}

init();