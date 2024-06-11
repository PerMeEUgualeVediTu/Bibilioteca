async function postData(url = "", data = {}) {
    const response = await fetch(url, { method: "POST", body: data });
    return response;
}

function login ( ) {
    var mail = document.getElementById( "login_mail" ).value;
    var pass = document.getElementById( "login_pswd" ).value;

    var formData = new FormData ( );
    formData.append( "mail", mail );
    formData.append( "pass", pass );

    console.log ( formData );

    postData ( "scripts/php/user-006/login.php", formData ).then (
        ( data ) => {
            data.text ( ).then ( 
                ( values ) => {
                    console.log ( values )
                }
            )
        }
    )
}

function register ( ) {
    var mail = document.getElementById( "register_mail" ).value;

    var formData = new FormData ( );
    formData.append( "mail", mail );

    console.log ( formData );

    postData ( "scripts/php/user-006/login.php", formData ).then (
        ( data ) => {
            data.text ( ).then ( 
                ( values ) => {
                    console.log ( values )
                }
            )
        }
    )
}