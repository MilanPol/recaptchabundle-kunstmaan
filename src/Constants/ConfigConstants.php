<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\Constants;

class ConfigConstants
{
    public const CONFIG_PREFIX_KEY = 'esites_recaptcha_bundle.';

    public const CONFIG_ENABLE_RECAPTCHA = 'enable_recaptcha';
    public const CONFIG_RECAPTCHA_KEY = 'recaptcha_key';
    public const CONFIG_RECAPTCHA_SECRET = 'recaptcha_secret';
    public const CONFIG_RECAPTCHA_SCORE = 'recaptcha_score';
    public const CONFIG_EXPECTED_HOSTNAME = 'expected_hostname';
    public const CONFIG_USE_CLIENT_IP = 'use_client_ip';

    public static function getConfigKeys(): array
    {
        return [
            static::CONFIG_ENABLE_RECAPTCHA,
            static::CONFIG_RECAPTCHA_KEY,
            static::CONFIG_RECAPTCHA_SECRET,
            static::CONFIG_RECAPTCHA_SCORE,
            static::CONFIG_EXPECTED_HOSTNAME,
            static::CONFIG_USE_CLIENT_IP,
        ];
    }

    public static function getParameterKeyName(string $key): string
    {
        return static::CONFIG_PREFIX_KEY . $key;
    }
}
