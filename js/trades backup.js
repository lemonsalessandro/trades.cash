let content = document.querySelector(".siteItems")
let url = 'https://steamcommunity-a.akamaihd.net/economy/image/';
let priceText = document.getElementById("priceValue");
let priceRange = document.getElementById("priceRange");
let inputItem = document.querySelectorAll('.inputItem')
let btnResetFilters = document.querySelector('#resetFilters');


let filterBtn = document.getElementById("applyFilters");

priceRange.addEventListener("change", () => {
  priceText.innerHTML = 'R$ ' + priceRange.value;
});

btnResetFilters.addEventListener('click', () => {
  priceText.innerHTML = 'R$';
})

async function getSkins(filter) {

  if (!filter) {
    const response = await fetch('js/tradeItems.php');
    const jsonData = await response.json();
    content.innerHTML = "";
    jsonData.forEach(skin => {
      content.innerHTML +=
        `<div class="label-wrapper">
          <label class="item" for='itemSite[]'>
              <div class="upper-text">
                  <span>${skin['estado']}</span>
              </div>
              <img draggable="false" class="item-img"
                  src="${url}${skin['itemImg']}">
              <div class="bottom-text">
                  <span>R$ ${skin['preco']}</span>
              </div>
  
              <input id="itemRaridade" type="hidden" value="${skin['raridade']}">
              <input id="inspectLink" type="hidden" value="${skin['inspectInGame']}">
              <input id="itemType" type="hidden" value="${skin['tipo']}">
              <input id="skinName" type="hidden" value="${skin['nomeSkin']}">
  
              <input type="checkbox" name="itemSite[]" class="inputItem" id="checkItem" value="${skin['idItemSite']}">
          </label>
          <div class="inspectItem"><i class="fa-solid fa-magnifying-glass"></i>Inspecionar</div>
        </div>`

    });
  } else {
    let maxPrice = priceRange.value;
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ filterActive, maxPrice })
    };

    const response = await fetch('./includes/logica/filtro.php', requestOptions);
    const jsonData = await response.json();
    content.innerHTML = "";

    jsonData.forEach(skin => {
      var templateContent = content.innerHTML +=
        `<div class="label-wrapper">
          <label class="item" for='itemSite[]'>
              <div class="upper-text">
                  <span>${skin['estado']}</span>
              </div>
              <img draggable="false" class="item-img"
                  src="${url}${skin['itemImg']}">
              <div class="bottom-text">
                  <span>R$ ${skin['preco']}</span>
              </div>
  
              <input id="itemRaridade" type="hidden" value="${skin['raridade']}">
              <input id="inspectLink" type="hidden" value="${skin['inspectLink']}">
              <input id="itemType" type="hidden" value="${skin['tipo']}">
              <input id="skinName" type="hidden" value="${skin['nomeSkin']}">
  
              <input type="checkbox" name="itemSite[]" class="inputItem" id="checkItem" value="${skin['idItemSite']}">
          </label>
          <div class="inspectItem"><i class="fa-solid fa-magnifying-glass"></i>Inspecionar</div>
        </div>`

    });
  }

}

getSkins(false).finally(() => {
  var items = document.querySelectorAll('.item');

  items.forEach((item) => {
    item.addEventListener('click', () => {
      item.classList.toggle('active');
      let input = item.querySelector('#checkItem');
      input.checked = !input.checked;
    })
  })

  let modal = document.getElementsByClassName('modal-item')[0];
  let modalContent = document.getElementsByClassName('modal-content')[0];
  let inspectBtn = document.querySelectorAll(".inspectItem");
  let closeModal = document.querySelector("#modalClose");
  
  //captura os dados do item clicado para adicionar no modal
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

    });
  }

  //fecha o modal pelo botao
  closeModal.addEventListener('click', () => {
    modal.classList.remove('open');
  });
});

let tradeBtn = document.querySelector('#trade-btn');
let popup = document.getElementById('popup');

tradeBtn.addEventListener('click', (e) => {
  let itemUserCheckboxes = document.querySelectorAll('input[name="itemUser[]"]');
  let itemSiteCheckboxes = document.querySelectorAll('input[name="itemSite[]"]');

  let isItemUserChecked = Array.from(itemUserCheckboxes).some(checkbox => {
    return checkbox.checked;
  });

  let isItemSiteChecked = Array.from(itemSiteCheckboxes).some(checkbox => {
    return checkbox.checked;
  });

  if (!isItemUserChecked || !isItemSiteChecked) {
    e.preventDefault();

    popup.classList.add('show');

    setTimeout(() => {
      popup.classList.remove('show');
    }, 3000);
  }
})

filterBtn.addEventListener('click', (event) => {
  maxPrice = priceRange.value
  filterActive = [];
  var filterCheckboxes = document.querySelectorAll('input[name="tipo[]');
  event.preventDefault();

  filterCheckboxes.forEach(teste => {
    if (teste.checked) {
      filterActive.push(teste.value);
    }
  })

  if (filterActive.length == 0) {
    filterActive = ["Faca", "Pistola", "Rifle", "Luva", "SMG"];
  }

  getSkins(true).finally(() => {
    var items = document.querySelectorAll('.item');

    items.forEach((item) => {
      item.addEventListener('click', () => {
        item.classList.toggle('active');
        let input = item.querySelector('#checkItem');
        input.checked = !input.checked;
      })
    })
    let modal = document.getElementsByClassName('modal-item')[0];
    let modalContent = document.getElementsByClassName('modal-content')[0];
    let inspectBtn = document.querySelectorAll(".inspectItem");
    let closeModal = document.querySelector("#modalClose");

    //captura os dados do item clicado para adicionar no modal
    for (let i = 0; i < inspectBtn.length; i++) {
      inspectBtn[i].addEventListener('click', () => {
        let itemImg = items[i].querySelector('.item-img').src;
        let estado = items[i].querySelector('.upper-text span').textContent;
        let itemPrice = items[i].querySelector('.bottom-text span').textContent;
        let raridade = items[i].querySelector('#itemRaridade').value;
        let itemType = items[i].querySelector('#itemType').value;
        let skinName = items[i].querySelector('#skinName').value;

        //captura os campos do modal para inserir os dados do item clicado
        let modalImg = document.querySelector("#imgModal")
        let skinNameModal = document.querySelector('#skinNameModal');
        let skinEstadoModal = document.querySelector('#skinEstadoModal');
        let skinTypeModal = document.querySelector('#skinTypeModal');
        let skinRaridadeModal = document.querySelector('#skinRaridadeModal');
        let skinPriceModal = document.querySelector('#skinPriceModal');

        //adiciona os dados do elemento clicado no modal
        modalImg.src = itemImg;
        skinNameModal.innerText = skinName;
        skinEstadoModal.innerText = estado;
        skinTypeModal.innerText = itemType;
        skinRaridadeModal.innerText = raridade;
        skinPriceModal.innerText = itemPrice;

        //adiciona a classe para exibir modal para o usuário
        modal.classList.add('open');

      });
    }

    //fecha o modal pelo botao
    closeModal.addEventListener('click', () => {
      modal.classList.remove('open');
    });
  })

})






