document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("addFundsModal");
    let btn = document.getElementById("addFunds");
    let span = document.getElementsByClassName("close")[0];
    let input = document.querySelector('#inputFund');
    let btnFund = document.querySelector('#btnFunds');
    let msg = document.querySelector('#msg');
    let payMethod = document.getElementsByName('method');

    btn.onclick = function () {
        modal.style.display = "block";
    }

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    btnFund.addEventListener('click', (e) => {
        let checkedMethods = Array.from(payMethod).some(method => {
            return method.checked;
        })

        if (input.value <= 0 || input.value >= 99999 || !validarNumeros(input.value) || !checkedMethods) {
            e.preventDefault();

            msg.style.color = 'red';
            msg.style.marginTop = '10px';
            msg.innerText = "[ERRO] Informe corretamente os dados necessários!";
        } else {
            msg.innerText = "";
            modal.style.display = "none";
        }
    });



    function validarNumeros(input) {
        var regex = /^[0-9]+$/; // Apenas dígitos de 0 a 9 são permitidos
        return regex.test(input);
    }


});