<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\Form;

use Esites\RecaptchaBundle\Constants\RecaptchaConstants;
use Esites\RecaptchaBundle\Exception\RecaptchaException;
use Esites\RecaptchaBundle\Service\RecaptchaService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

abstract class AbstractRecaptchaType extends AbstractType
{
    protected RecaptchaService $recaptchaService;

    public function __construct(
        RecaptchaService $recaptchaService
    ) {
        $this->recaptchaService = $recaptchaService;
    }

    abstract public function getExpectedAction(): string;

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        parent::buildForm(
            $builder,
            $options
        );

        $builder
            ->add(
                RecaptchaConstants::RECAPTCHA_FIELD_NAME,
                HiddenType::class,
                [
                    'required'       => true,
                    'mapped'         => false,
                    'constraints'    => [
                        new NotBlank(),
                        new Callback(
                            [
                                $this,
                                'validateRecaptcha',
                            ]
                        ),
                    ],
                    'error_bubbling' => true,
                    'attr'           => [
                        RecaptchaConstants::RECAPTCHA_INPUT_ATTRIBUTE  => true,
                        RecaptchaConstants::RECAPTCHA_ACTION_ATTRIBUTE => $this->getExpectedAction(),
                        RecaptchaConstants::RECAPTCHA_KEY_ATTRIBUTE => $this->recaptchaService->getRecaptchaKey(),
                    ],
                ]
            );
    }

    public function validateRecaptcha(
        ?string $recaptchaToken,
        ExecutionContextInterface $context
    ): void {
        try {
            if (!is_string($recaptchaToken)) {
                throw new RecaptchaException('Empty token');
            }

            $this->recaptchaService->assertRecaptcha(
                $recaptchaToken,
                $this->getExpectedAction()
            );
        } catch (RecaptchaException $exception) {
            $context
                ->buildViolation(
                    'error.recaptcha_failed_to_validate'
                )
                ->addViolation();
        }
    }
}
