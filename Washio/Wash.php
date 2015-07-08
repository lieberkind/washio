<?php

namespace Washio;

class Wash
{
    /**
     * The timestamp of the washing time
     *
     * @var \DateTime
     */
    protected $time;

    /**
     * The location of the washing time
     *
     * @var string
     */
    protected $location;

    /**
     * Create an instance of a WashingTime
     *
     * @param DateTime $time
     * @param string $location
     */
    public function __construct(\DateTime $time, $location)
    {
        $this->time = $time;
        $this->location = $location;
    }

    /**
     * Get the time of the wash
     *
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get the location of the wash
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
