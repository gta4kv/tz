<?php


namespace App\Entity;


class LifetimeDuration
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int|null
     */
    private $durationHours;

    /**
     * LifetimeDuration constructor.
     * @param $name
     * @param $durationHours
     */
    public function __construct($name, $durationHours)
    {
        $this->name = $name;
        $this->durationHours = $durationHours;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getDurationHours(): ?int
    {
        return $this->durationHours;
    }
}