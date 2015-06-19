<?php

namespace LapaLabs\MediaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\UrlValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

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
        if (!$constraint instanceof YouTubeResourceUrl) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\YouTubeResourceUrl');
        }

        if (null === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;
        if ('' === $value) {
            return;
        }

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
