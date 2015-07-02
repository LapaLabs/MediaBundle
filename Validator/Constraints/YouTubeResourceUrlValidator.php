<?php

namespace LapaLabs\MediaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\UrlValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class YouTubeResourceUrlValidator
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License
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
                    // https://www.youtube.com/embed/Mmh-ew1swD4

                    if (true
                        and true === isset($parsedUrl['path'])
                        and true === isset($parsedUrl['query'])
                        and 0 === strcmp('/watch', $parsedUrl['path'])
                        and null == parse_str($parsedUrl['query'], $output)
                        and true === isset($output['v'])
                        and 11 === strlen($output['v'])
                    ) {
                        ;
                    } elseif (true
                        and true === isset($parsedUrl['path'])
                        and 1 === preg_match('@^/embed/(?<v>[\w-]{11})($|/|#|\?)@', $parsedUrl['path'], $matches)
                    ) {
                        ;
                    } else {
                        $this->context->buildViolation($constraint->hostMessage)
                            ->setParameter('%host%', $this->formatValue($parsedUrl['host']))
                            ->addViolation();
                    }

                    break;
                case 'youtu.be':
                    // https://youtu.be/YKwDcLUXlvU

                    if (true
                        and true === isset($parsedUrl['path'])
                        and 1 === preg_match('@^/(?<v>[\w-]{11})($|/|#|\?)@', $parsedUrl['path'], $matches)
                    ) {
                        ;
                    } else {
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
