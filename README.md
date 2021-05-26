# RecaptchaBundle

## Usage

Extend any form to `AbstractRecaptchaType`. This requires you to define `getExpectedAction()`. Return the expected action (for example `contact` for a contact form).

Next, in the twig template in which your form is being used, include the following:

```twig
{% include '@EsitesRecaptcha/recaptcha/recaptcha.html.twig' %}
```

Finally, install the assets using `php bin/console assets:install`

## Errors

When the recaptcha check fails, an error will be added to the form. To display it, use:
```twig
{{ form_errors(form) }}
```

The message is translatable by defining the following in validators.nl.yml
```yaml
error:
    recaptcha_failed_to_validate: 'Recaptcha failed!'
```

## Full Configuration

```yaml
esites_recaptcha:
    enable_recaptcha: true   # default value
    recaptcha_key: google_recaptcha_key   # required, the key from the google recaptcha admin dashboard
    recaptcha_secret: google_recaptcha_secret   # required, the secret key from the google recaptcha admin dashboard
    recaptcha_score: 0.5   # default value, the minimum score a visitor has to score to not be flagged as a bot
    expected_hostname: e-sites.nl   # not required, the expected hostname in the google recaptcha response
    use_client_ip: true   # default value, also sends the clients ip to verify the recaptcha request
```

## Manually renewing a recaptcha

Select the recaptcha element (the hidden input) you wish the renew and call `setRecaptcha();`
```javascript
setRecaptcha(document.querySelector('#recaptchaObject'));
```
