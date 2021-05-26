<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RecaptchaExtension extends AbstractExtension
{
    private string $recaptchaKey;

    private int $numberOfRecaptchaIncludes = 0;

    public function __construct(
        string $recaptchaKey
    ) {
        $this->recaptchaKey = $recaptchaKey;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_recaptcha_key',
                [
                    $this,
                    'getRecaptchaKey',
                ]
            ),
            new TwigFunction('get_number_of_recaptcha_includes',
                [
                    $this,
                    'getNumberOfRecaptchaIncludes',
                ]
            ),
        ];
    }

    public function getRecaptchaKey(): string
    {
        return $this->recaptchaKey;
    }

    public function getNumberOfRecaptchaIncludes(): int
    {
        return $this->numberOfRecaptchaIncludes++;
    }
}
