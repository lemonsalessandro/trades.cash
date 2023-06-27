let items = document.querySelectorAll('.item');

//estilização dos itens selecionados
items.forEach(item => {
  item.addEventListener('click', () => {
    item.classList.toggle('active');
    let input = item.querySelector('#checkItem');
    input.checked = !input.checked;
  })
})

//validação dos itens selecionados 
let tradeBtn = document.querySelector('#trade-btn');
let popup = document.getElementById('popup');

tradeBtn.addEventListener('click', (e) => {
  let itemUserCheckboxes = document.querySelectorAll('input[name="itemUser[]"]');

  // Verificação dos checkboxes usuário e site (ao menos um deve estar selecionado em ambos inventarios)
  let isItemUserChecked = Array.from(itemUserCheckboxes).some(checkbox => {
    return checkbox.checked;
  });

  if (!isItemUserChecked) {
    e.preventDefault();

    popup.classList.add('show');

    setTimeout(() => {
      popup.classList.remove('show');
    }, 3000);
  }
})

//modal com o item selecionado
let modal = document.getElementsByClassName('modal-item')[0];
let modalContent = document.getElementsByClassName('modal-content')[0];
let inspectBtn = document.querySelectorAll(".inspectItem");
let closeModal = document.querySelector("#modalClose");

// //captura os dados do item clicado para adicionar no modal
for (let i = 0; i < inspectBtn.length; i++) {
  inspectBtn[i].addEventListener('click', () => {
    let itemImg = items[i].querySelector('.item-img').src;
    let estado = items[i].querySelector('.upper-text span').textContent;
    let itemPrice = items[i].querySelector('.bottom-text span').textContent;
    let raridade = items[i].querySelector('#itemRaridade').value;
    let itemType = items[i].querySelector('#itemType').value;
    let skinName = items[i].querySelector('#skinName').value;
    let inspectLink = items[i].querySelector('#inspectLink').value;


    //captura os campos do modal para inserir os dados do item clicado
    let modalImg = document.querySelector("#imgModal")
    let skinNameModal = document.querySelector('#skinNameModal');
    let skinEstadoModal = document.querySelector('#skinEstadoModal');
    let skinTypeModal = document.querySelector('#skinTypeModal');
    let skinRaridadeModal = document.querySelector('#skinRaridadeModal');
    let skinPriceModal = document.querySelector('#skinPriceModal');
    let inspectInGame = document.querySelector('.inspectInGame');


    //adiciona os dados do elemento clicado no modal
    modalImg.src = itemImg;
    skinNameModal.innerText = skinName;
    skinEstadoModal.innerText = estado;
    skinTypeModal.innerText = itemType;
    skinRaridadeModal.innerText = raridade;
    skinPriceModal.innerText = itemPrice;
    inspectInGame.href = inspectLink;

    //adiciona a classe para exibir modal para o usuário
    modal.classList.add('open');
    document.body.style.overflow = "hidden";


    //verificar como selecionar o item a partir do botão do modal

    let cartButton = document.querySelector('.cart');

    let checkboxModal = items[i].querySelector('#checkItem')

    cartButton.addEventListener('click', () => {
      console.log(checkboxModal.checked);

    })

  });
}

//fecha o modal pelo botao
closeModal.addEventListener('click', () => {
  modal.classList.remove('open');
});





