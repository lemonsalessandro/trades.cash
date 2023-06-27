const form = document.getElementById('formCadastro');
const nome = document.getElementById('nome')
const email = document.getElementById('email')
const senha = document.getElementById('senha')

let regex_validation = /^([a-z]){1,}([a-z0-9._-]){1,}([@]){1}([a-z]){2,}([.]){1}([a-z]){2,}([.]?){1}([a-z]?){2,}$/i;

let error = document.getElementById('error-msg');

form.addEventListener("submit", event => {

    if (nome.value.length < 3) {
        event.preventDefault()
        error.innerText = '[ERRO] Insira um nome válido!'
    }

    if (validatorEmail(email.value) !== true) {
        error.innerText = "[ERRO] Insira um email válido";
        event.preventDefault()
    }

    if (senha.value.length < 5) {
        error.innerText = "[ERRO] Sua senha deve ter no mínimo 5 caracteres";
        event.preventDefault();
    }

})

function validatorEmail(email) {
    let emailPattern =
        /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
    return emailPattern.test(email);
}