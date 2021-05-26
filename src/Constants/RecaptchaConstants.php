<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\Constants;

class RecaptchaConstants
{
    public const RECAPTCHA_FIELD_NAME = 'recaptcha';
    public const RECAPTCHA_INPUT_ATTRIBUTE = 'data-recaptcha-input';
    public const RECAPTCHA_ACTION_ATTRIBUTE = 'data-recaptcha-action';
    public const RECAPTCHA_KEY_ATTRIBUTE = 'data-recaptcha-key';

    public const DEFAULT_RECAPTCHA_SCORE = 0.5;

    public const TOKEN_TIMEOUT_IN_SECONDS = 120;
}
