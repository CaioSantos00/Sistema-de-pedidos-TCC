import {consultarClassificacoes, transformaMaiusculo} from "./functionsProducts.js"

let btnBuscaPedido = document.getElementById('btnBuscaPedido'),
    inputBusca = document.getElementById('inputBusca'),
    sectionProducts = document.getElementById('sectionProducts')

    function criaCardDaConsulta(nomeDaClass) {
        let cardsClass = document.createElement('div')
        cardsClass.classList.add('cardsClass')

        let nomeClass = document.createElement('div')
        nomeClass.classList.add('nomeClass')
        nomeClass.innerText = nomeDaClass

        let divEditExclu = document.createElement('div')
        divEditExclu.classList.add('divEditExclu')
        let btnsExcluClass = document.createElement('button')
        btnsExcluClass.classList.add('btnsExcluClass')
        btnsExcluClass.innerText = 'Excluir'
        let btnsEditClass = document.createElement('button')
        btnsEditClass.classList.add('btnsEditClass')
        btnsEditClass.innerText = 'Editar'
        divEditExclu.append(btnsExcluClass, btnsEditClass)

        cardsClass.append(nomeClass, divEditExclu)
        sectionProducts.appendChild(cardsClass)
    }

    btnBuscaPedido.addEventListener('click', async ()=>{
        let limpaStr = inputBusca.value.trim()
        if (limpaStr == '') {
            alert("Digite o nome da classificação")
        } else {
            sectionProducts.innerHTML = '';
        if (limpaStr) {
            let newTexto = transformaMaiusculo(limpaStr)
            newTexto.trim()
            let opcoes = await consultarClassificacoes();
            opcoes.forEach((e) => {
                if (newTexto == e || transformaMaiusculo(e).startsWith(newTexto)) {
                    criaCardDaConsulta(e)
                } else {
                    console.log("Não Encontrado")
                }
            });
            inputBusca.value = ''
        } }
    })