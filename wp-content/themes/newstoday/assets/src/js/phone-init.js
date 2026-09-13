document.addEventListener("DOMContentLoaded", function () {
    var input = document.querySelector("#phone");

    if (!input) {
        return;
    }

    window.intlTelInput(input, {
        initialCountry: "gb",
        separateDialCode: true,
        preferredCountries: ["gb", "us", "in", "ae"],
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/utils.js"
    });
});

document.addEventListener("wpcf7beforesubmit", function (event) {
    var input = document.querySelector("#phone");
    var iti = window.intlTelInputGlobals.getInstance(input);

    if (!input || !iti) {
        return;
    }

    var fullNumber = iti.getNumber();
    document.querySelector("#full_phone").value = fullNumber;
});
