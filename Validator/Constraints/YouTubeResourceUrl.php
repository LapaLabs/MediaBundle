<?php

namespace LapaLabs\MediaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Url;

/**
 * @Annotation
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 */
class YouTubeResourceUrl extends Url
{
    public $message = 'This value is not a valid YouTube resource URL.';

    public $hostMessage = 'This value is not a valid YouTube resource URL for %host%.';
}
