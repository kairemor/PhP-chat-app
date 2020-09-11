function getMessage(){
    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("GET" , "handler.php") ;
    requeteAjax.onload = function(){
        const resultat =  JSON.parse(requeteAjax.responseText) ;
        console.log(requeteAjax);
        console.log(resultat) ;

        const html = resultat.map(function(message){
        return `
            <div class="message">
                    <span class="author">${message.cration_date}  </span>
                    <span class="author">${message.author} : </span>
                    <span class="content">
                        <p>
                            ${message.content}
                        </p>
                    </span>
                </div>
            `
        }).join('');
        const messages = document.getElementById('messages');
        messages.innerHTML = html
    }
    requeteAjax.send() ;
}

function postMessage(e){
    e.preventDefault();

    const author = document.querySelector('#author') ;
    const content = document.querySelector('#content') ;

    const data = new FormData();
    data.  append('author', author.value);
    data.append('content', content.value);

    const requeteAjax = new XMLHttpRequest();
    requeteAjax.open("POST", 'handler.php?task=write');
    requeteAjax.onload = function(){
        content.value = '';
        content.focus() ;
        getMessage();
    }
    requeteAjax.send(data);
}

document.querySelector('form').addEventListener('submit', postMessage);

const interval = window.setInterval(getMessage, 2000) ;

// getMessage();
