var movableObject = document.getElementById("active"),
    loginFace = document.getElementById("login"),
    input = document.getElementsByClassName("form-control"),
    registerFace = document.getElementById("sign-up");
var fons = document.getElementById("body");
var speedmove = 900;
var speedfade = 500;


function registerActive() {
    $(movableObject).animate({
        left: '-420px'
    }, speedmove);
    $(loginFace).fadeOut(speedfade, "swing", $(registerFace).fadeIn(speedfade));
}

function loginActive() {
    $(movableObject).animate({
        left: '0px'
    }, speedmove);
    $(registerFace).fadeOut(speedfade, "linear", $(loginFace).fadeIn(speedfade));
}
function mobileActive() {
 
    $(loginFace).fadeOut(speedfade, "swing", $(registerFace).fadeIn(speedfade));
}
function mobileLoginActive()
{
	 $(registerFace).fadeOut(speedfade, "linear", $(loginFace).fadeIn(speedfade));
}

function inputActive(x) {
    $(x).siblings(".input-name").css({
        "font-size": "11px",
        "font-weight": "bold",
        "text-transform": "uppercase"
    });
    $(x).siblings(".active-image-mail").css({
        "background-image": "url(../images/ic_mail_active.png)"
    });
    $(x).siblings(".active-image-user").css({
        "background-image": "url(../images/ic_user_active.png)"
    });
    $(x).siblings(".active-image-lock").css({
        "background-image": "url(../images/ic_lock_active.png)"
    });
}

function inputNotActive(x) {
    $(x).siblings(".input-name").css({
        "font-size": "16px",
        "font-weight": "normal",
        "text-transform": "none"
    });
    $(x).siblings(".active-image-mail").css({
        "background-image": "url(../images/ic_mail.png)"
    });
    $(x).siblings(".active-image-user").css({
        "background-image": "url(../images/ic_user.png)"
    });
    $(x).siblings(".active-image-lock").css({
        "background-image": "url(../images/ic_lock.png)"
    });
}

$(input)
    .keypress(function() {
        inputActive(this);

    })

.focusout(function() {
    var inputLength = $(this).val().length;
    if (inputLength == 0) {

        inputNotActive(this);

    } else if (inputLength != 0) {
        inputActive(this);
    }
})