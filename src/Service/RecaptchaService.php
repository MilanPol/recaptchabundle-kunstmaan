<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\Service;

use Esites\RecaptchaBundle\Exception\RecaptchaException;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaService
{
    private RequestStack $requestStack;

    private string $recaptchaKey;

    private string $recaptchaSecret;

    private ?string $expectedHostname;

    private float $recaptchaScore;

    private array $validatedTokens = [];

    private bool $recaptchaEnabled;

    private bool $useClientIp;

    public function __construct(
        RequestStack $requestStack,
        string $recaptchaKey,
        string $recaptchaSecret,
        ?string $expectedHostname,
        float $recaptchaScore,
        bool $recaptchaEnabled,
        bool $useClientIp
    ) {
        $this->requestStack = $requestStack;
        $this->recaptchaKey = $recaptchaKey;
        $this->recaptchaSecret = $recaptchaSecret;
        $this->recaptchaScore = $recaptchaScore;
        $this->expectedHostname = $expectedHostname;
        $this->recaptchaEnabled = $recaptchaEnabled;
        $this->useClientIp = $useClientIp;
    }

    /**
     * @throws RecaptchaException
     */
    public function assertRecaptcha(
        string $recaptchaResponse,
        string $expectedAction
    ): void {
        if (!$this->recaptchaEnabled) {
            return;
        }

        $isValid = $this->isValidRecaptcha(
            $recaptchaResponse,
            $expectedAction
        );

        if (!$isValid) {
            throw new RecaptchaException('Validation was not successful');
        }
    }

    private function isValidRecaptcha(
        string $recaptchaResponse,
        string $expectedAction
    ): bool {
        if (isset($this->validatedTokens[$recaptchaResponse])) {
            return (bool) $this->validatedTokens[$recaptchaResponse];
        }

        $response = $this->getRecaptchaResponse(
            $recaptchaResponse,
            $expectedAction
        );

        $this->validatedTokens[$recaptchaResponse] = $response->isSuccess();

        return $response->isSuccess();
    }

    private function getRecaptchaResponse(
        string $recaptchaResponse,
        string $expectedAction
    ): Response {
        $recaptcha = new ReCaptcha($this->recaptchaSecret);

        if (is_string($this->expectedHostname)) {
            $recaptcha->setExpectedHostname($this->expectedHostname);
        }

        return $recaptcha
            ->setExpectedAction($expectedAction)
            ->setScoreThreshold($this->recaptchaScore)
            ->verify(
                $recaptchaResponse,
                $this->getClientIp()
            )
            ;
    }

    private function getClientIp(): ?string
    {
        if (!$this->useClientIp) {
            return null;
        }

        $request = $this->requestStack->getCurrentRequest();

        if (!$request instanceof Request) {
            return null;
        }

        return $request->getClientIp();
    }

    public function getRecaptchaKey(): string
    {
        return $this->recaptchaKey;
    }
}
