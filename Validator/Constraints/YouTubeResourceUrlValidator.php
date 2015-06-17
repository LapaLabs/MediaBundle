<?php

namespace LapaLabs\MediaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\UrlValidator;

/**
 * Class YouTubeResourceUrlValidator
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class YouTubeResourceUrlValidator extends UrlValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $parsedUrl = parse_url($value);

        if (isset($parsedUrl['host'])) {
            parent::validate($value, $constraint);

            switch (strtolower($parsedUrl['host'])) {
                case 'youtube.com':
                case 'm.youtube.com':
                case 'www.youtube.com':
                    // https://www.youtube.com/watch?v=YKwDcLUXlvU

                    if (false
                        or false === isset($parsedUrl['query'])
                        or false === isset($parsedUrl['path'])
                        or 0 !== strcmp('/watch', $parsedUrl['path'])
                        or parse_str($parsedUrl['query'], $output)
                        or false === isset($output['v'])
                        or 11 !== strlen($output['v'])
                    ) {
                        $this->context->buildViolation($constraint->hostMessage)
                            ->setParameter('%host%', $this->formatValue($parsedUrl['host']))
                            ->addViolation();
                    }

                    break;
                case 'youtu.be':
                    // https://youtu.be/YKwDcLUXlvU

                    if (false
                        or false === isset($parsedUrl['path'])
                        or 1 !== preg_match('@^/[\w-]{11}($|/|#|\?)@', $parsedUrl['path'])
                    ) {
                        $this->context->buildViolation($constraint->hostMessage)
                            ->setParameter('%host%', $this->formatValue($parsedUrl['host']))
                            ->addViolation();
                    }

                    break;
                default:
                    $this->context->buildViolation($constraint->message)
                        ->addViolation();
            }
        } else {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

        unset($parsedUrl);
        unset($output);
    }
}
