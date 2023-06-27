let carteira = document.querySelector("#amount")

function atualizaCredito() {
  fetch('./includes/logica/carteira.php')
    .then(function (response) {
      if (response.ok) {
        return response.json();
      }
    })
    .then(data => {
      carteira.innerHTML = 'R$ ' + data.valorCarteira;
    })
    .catch(error => {
      console.error(error);
    });
}

atualizaCredito();