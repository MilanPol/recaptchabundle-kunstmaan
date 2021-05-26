function setRecaptchas() {
  document
    .querySelectorAll('input[data-recaptcha-input]')
    .forEach(function (recaptchaElement) {
      setRecaptcha(recaptchaElement);
    })
}

function setRecaptcha(recaptchaElement) {
  grecaptcha.ready(function () {
    grecaptcha.execute(recaptchaElement.getAttribute('data-recaptcha-key'), {
      action: recaptchaElement.getAttribute('data-recaptcha-action')
    }).then(
      function (token) {
        recaptchaElement.value = token;
      }
    );
  });
}

setRecaptchas();

setInterval(function () {
  setRecaptchas();
}, 120000);
