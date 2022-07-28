const btnSubmit = document.getElementById('form-submit');
const iPassword = document.getElementById('password');
const iUsername = document.getElementById('username');
const iFormSpinner = document.getElementById('form-spinner');
const pError = document.getElementById('reg-error');
const form = btnSubmit.parentNode.parentNode;

function init(){
  btnSubmit.addEventListener('click', function(e){
    e.preventDefault();
    pError.style.visibility = 'hidden';
    iUsername.style.borderColor = '#e1e5ee';
    iPassword.style.borderColor = '#e1e5ee';
    if(isFormFilled()){
      //form.submit();
      isCredentialValid(iUsername.value, iPassword.value);
    }
  });
}

async function isCredentialValid(u,p){
  btnSubmit.parentNode.style.display = 'none';
  iFormSpinner.style.display = 'flex';
  iUsername.disabled = true;
  iPassword.disabled = true;
  let data = {
    "username": u,
    "password": p
  }
  await new Promise(r => setTimeout(r, 2000)); //biar keren aja
  fetch('login', {
    method: 'post',
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  })
  .then(function(response){
    return response.json();
  })
  .then(function(data){
    console.log(data);
    if(data == false){
      iFormSpinner.style.display = 'none';
      btnSubmit.parentNode.style.display = 'block';
      iUsername.style.borderColor = 'red';
      iPassword.style.borderColor = 'red';
      pError.style.visibility = 'visible';
      iUsername.disabled = false;
      iPassword.disabled = false;
    }else{
      window.location.href = "profile";
    }
  });
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

init();