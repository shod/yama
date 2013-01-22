$(document).bind("ready", function init() {

    $.fn.message = function(text) {
        var error = $("<div>", {
            "class": "error-message"
        }).append($("<div>", {
            text: text
        }))
        error.insertAfter(this)
        error.css("width", this.outerWidth())
        error.position({
            of: this,
            my: "center bottom",
            at: "center top"
        })
        error.hide()
        return error
    }

    $(".auth, form").on("focusin focusout", "input", function(e) {
        if (e.type == "focusin") {
            $(e.target).next(".error-message").fadeIn();
        } else {
            $(e.target).next(".error-message").fadeOut();
        }
    })

    $.fn.validateAttrs = function(data) {
        this.find("input").removeClass("error").next(".error-message").remove()
        for (attr in data)
        {
            $("#"+attr).addClass("error").message(data[attr]).fadeIn().delay(1500).fadeOut();
        }
    }

    $(".remind, .password-recover .close, .password-recover .cancel-link").on("click", function(e) {
        $(".popup-fader, .password-recover").toggle()
        $("#formRemind #Form_Remind_email").val($("#formLogin #Form_Login_email").val())
        $(".password-recover").css("margin-top", $(".password-recover").outerHeight() / -2)
    })
})