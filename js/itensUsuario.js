let content = document.getElementById('content')
let url = 'https://steamcommunity-a.akamaihd.net/economy/image/';
const checkboxes = document.getElementsByClassName('checkBtn');
let message = document.getElementById('msg');

async function getSkins() {

    const allSkins = await fetch('./js/itens.json')
    const response = await allSkins.json()
    // console.log(response)
    response.skins.forEach(skin => {
        content.innerHTML +=
            `<div class='item'>
                <img width='140px' src=${url}${skin.imagem}/> 
                <p>${skin.nome}</p>
                <input type='checkbox' class='checkBtn' id=${skin.nome}>
            </div>`
    });
}

getSkins();

content.innerHTML += `<button type='submit' id='btnSkins'>Adicionar Itens</button>`

content.addEventListener('submit', event => {
    event.preventDefault();

    let itens = []

    for (let x = 0; x < checkboxes.length; x++) {
        if (checkboxes[x].checked) {
            itens.push(x);
        }
    }

    var headers = {
        "Content-Type": "application/json",
        "Access-Control-Origin": "*"
    }

    const formData = new FormData()

    formData.append('posts', JSON.stringify(itens))

    async function userChange() {
        const dados = await fetch('./includes/logica/adicionarItemUsuario.php', {
            method: "POST",
            headers: headers,
            body: JSON.stringify(itens)
        }).then((data) => data.json())
    }

    userChange();

    if (itens.length !== 0) {
        message.innerHTML = `<h1>Itens adicionados com sucesso!</h1>`
    }
    else{
        message.innerHTML = `<h1>Nenhum item selecionado!</h1>`
    }

})
