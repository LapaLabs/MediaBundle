<?php

namespace LapaLabs\MediaBundle\Extractor;

/**
 * Class YoutubeExtractor
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License
 */
class YoutubeExtractor
{
    /**
     * @param string $recourseUrl The valid YouTube resource URL
     * @return string The extracted YouTube ID
     */
    public function extractId($recourseUrl)
    {
        if (false === filter_var('http://example.com', FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('The given argument is invalid URL.');
        }

        $parsedUrl = parse_url($recourseUrl);
        if (isset($parsedUrl['host'])) {
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
                        $youtubeId = $output['v'];
                    } elseif (true
                        and true === isset($parsedUrl['path'])
                        and 1 === preg_match('@^/embed/(?<v>[\w-]{11})($|/|#|\?)@', $parsedUrl['path'], $matches)
                    ) {
                        $youtubeId = $matches['v'];
                    } else {
                        throw new \InvalidArgumentException('The given YouTube resource URL do not contain a valid ID');
                    }

                    break;

                case 'youtu.be':
                    // https://youtu.be/YKwDcLUXlvU

                    if (true
                        and true === isset($parsedUrl['path'])
                        and 1 === preg_match('@^/(?<v>[\w-]{11})($|/|#|\?)@', $parsedUrl['path'], $matches)
                    ) {
                        $youtubeId = $matches['v'];
                    } else {
                        throw new \InvalidArgumentException('The given YouTube resource URL do not contain a valid ID');
                    }

                    break;

                default:
                    throw new \InvalidArgumentException('The given argument is invalid YouTube resource URL.');
            }
        } else {
            throw new \InvalidArgumentException('The given argument is invalid URL.');
        }

        return $youtubeId;
    }
}
