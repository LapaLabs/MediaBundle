<?php

namespace LapaLabs\MediaBundle\Model;

/**
 * Class RotatableImage
 *
 * @author Victor Bocharsky <bocharsky.bw@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License
 */
trait RotatableImage
{
    /**
     * @var int The image angle in degrees
     *
     * @ORM\Column(type="integer")
     */
    protected $angle = 0;

    /**
     * @param int $angle
     * @return $this
     */
    public function setAngle($angle)
    {
        $this->angle = (int)$angle;

        return $this;
    }

    /**
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }
}
