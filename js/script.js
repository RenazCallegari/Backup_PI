//=============================================codigos para estilização da pagina inicial=============================================


ScrollReveal({ 
    reset: true,
    distance: '30px',
    duration: 900,
    delay: 200
});

ScrollReveal().reveal('.estetica-logo', { origin: 'top' });
ScrollReveal().reveal('.estetica-texto', { origin: 'bottom' });
ScrollReveal().reveal('.container-login', { origin: 'right' });
ScrollReveal().reveal('.login-text', { origin: 'top' });
ScrollReveal().reveal('.div-line', { origin: 'bottom' });
ScrollReveal().reveal('.prod-by', { origin: 'left' });
ScrollReveal().reveal('.container-login-area', { origin: 'right' });


  

//=============================================codigos para estilização da pagina home===================================================



var menuItem = document.querySelectorAll('.item-menu')

function selectLink(){
    menuItem.forEach((item)=>
        item.classList.remove('ativo')
    )
    this.classList.add('ativo')
}

menuItem.forEach((item)=>
    item.addEventListener('click', selectLink)

)


//Expandir o menu

var btnExp = document.querySelector('#btn-exp')
var menuSide = document.querySelector('.sidebar')

btnExp.addEventListener('click', function(){
    menuSide.classList.toggle('expandir')
})





// ========================FUNÇÃO PARA MOSTRAR A SENHA================== 

function MostrarSenha(){
    var passwordInput = document.getElementById("senha");
    var showPasswordButton = document.getElementById("MostrarSenha");

    
        if (passwordInput.type === "password") {
            passwordInput.setAttribute('type','text');
            showPasswordButton.classList.replace('bx-show','bx-hide');
        } else {
            passwordInput.setAttribute('type','password');
            showPasswordButton.classList.replace('bx-hide','bx-show');
        }
;
}

/*================= JANELA MODAL POPUP PARA LOGOFF ===================*/

function abrirPopup() {
    const popup = document.getElementById("janela-popup")
    popup.classList.add('abrir')

    popup.addEventListener('click', (e) => {
        if(e.target.id == 'fechar' || e.target.id == 'janela-popup'){
            popup.classList.remove('abrir')
        }
    })
}

function fecharPopup() {
    const popup = document.getElementById("janela-popup")

    popup.addEventListener('click', (e) => {
            popup.classList.remove('abrir')
    })
}


/*================= JANELA MODAL CONFIRMAÇÃO DE LOGOFF ===================*/

function abrirModal() { 
    const modal = document.getElementById("janela-modal")
    modal.classList.add('abrir')

    modal.addEventListener('click', (e) => {
        if(e.target.id == 'fechar' || e.target.id == 'janela-modal'){
            modal.classList.remove('abrir')
        }
    })
}

/*================= FECHAR JANELA DE ERRO DA HOME ===================*/

function fecharErro() { 
    const erro = document.getElementById("erro-box-home")

    erro.addEventListener('click', (e) => {
        if(e.target.id == 'fechar' || e.target.id == 'janela-modal'){
            erro.classList.add('fechar')
        }
    })
}

/*================= FECHAR JANELA DE SUCESSO DA HOME ===================*/

function fecharSucesso() { 
    const sucesso = document.getElementById("sucesso-box-home")

    sucesso.addEventListener('click', (e) => {
        if(e.target.id == 'fechar' || e.target.id == 'janela-modal'){
            sucesso.classList.add('fechar')
        }
    })
}