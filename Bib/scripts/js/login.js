const regex_mail = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/
const re = new RegExp(regex_mail);
const log = document.getElementsByClassName('error')[0];
const mail = document.querySelectorAll('#USR')[0];
const pass = document.querySelectorAll('#PSW')[0];
const button = document.getElementById ( "cok?" );




async function postData(url = "", data = {}) {
    const response = await fetch(url, { method: "POST", body: data });
    return response;
}

function login 
( ) {
    var login_mail = mail.value;
    var login_pass = pass.value;

    console.log (login_mail);

    // check

    var formData = new FormData ( );
    formData.append( "mail", login_mail );
    formData.append( "pass", login_pass );
    formData.append( "mode", 1 );
    console.log ( formData );

    postData ( "scripts/php/user.php", formData ).then (
        ( data ) => {
            data.text ( ).then ( 
                ( values ) => {
                    alert ( values );
                    console.log ( values )
                }
            )
        }
    )
}

header.style.backgroundColor = '#29323c';