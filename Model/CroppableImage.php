<?php

namespace LapaLabs\MediaBundle\Model;

/**
 * Class CroppableImage
 */
trait CroppableImage
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $offsetX = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $offsetY = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $resultWidth = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $resultHeight = 0;

    /**
     * Set offsetX
     *
     * @param int $offsetX
     * @return $this
     */
    public function setOffsetX($offsetX)
    {
        $this->offsetX = (int)$offsetX;

        return $this;
    }

    /**
     * Get offsetX
     *
     * @return int
     */
    public function getOffsetX()
    {
        return $this->offsetX;
    }

    /**
     * Set offsetY
     *
     * @param int $offsetY
     * @return $this
     */
    public function setOffsetY($offsetY)
    {
        $this->offsetY = (int)$offsetY;

        return $this;
    }

    /**
     * Get offsetY
     *
     * @return int
     */
    public function getOffsetY()
    {
        return $this->offsetY;
    }

    /**
     * Set width
     *
     * @param int $resultWidth
     * @return $this
     */
    public function setResultWidth($resultWidth)
    {
        $this->resultWidth = (int)$resultWidth;

        if (0 >= $this->resultWidth) {
            throw new \InvalidArgumentException('The result image width should be greater then 0.');
        }

        return $this;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getResultWidth()
    {
        return $this->resultWidth;
    }

    /**
     * Set height
     *
     * @param int $resultHeight
     * @return $this
     */
    public function setResultHeight($resultHeight)
    {
        $this->resultHeight = (int)$resultHeight;

        if (0 >= $this->resultHeight) {
            throw new \InvalidArgumentException('The result image height should be greater then 0.');
        }

        return $this;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getResultHeight()
    {
        return $this->resultHeight;
    }
}
