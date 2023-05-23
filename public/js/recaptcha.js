// to set recaptcha for forms run this on window load and set data-grecaptcha-action to the form 
//ex:         <form action="{{route('contact form submit')}}" data-grecaptcha-action="contactformsubmit" method="POST">
function setRecaptcha(){
    var grecaptchaKeyMeta = document.querySelector("meta[name='grecaptcha-key']");
    var grecaptchaKey = grecaptchaKeyMeta.getAttribute("content");
    grecaptcha.ready(function() {
        var forms = document.querySelectorAll('form[data-grecaptcha-action]');

        Array.from(forms).forEach(function (form) {
            form.onsubmit = (e) => {
                e.preventDefault();
                var grecaptchaAction = form.getAttribute('data-grecaptcha-action');
                grecaptcha.execute(grecaptchaKey, {action: grecaptchaAction})
                    .then((token) => {
                        input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'grecaptcha';
                        input.value = token;
                        form.append(input);

                        form.submit();
                    });
            }
        });
    });
}