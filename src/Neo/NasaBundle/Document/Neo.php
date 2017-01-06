<?php
/**
 * Created by PhpStMongoDB.
 * User: Ulukut
 * Date: 5.12.2016
 * Time: 11:05
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Neo\NasaBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="Neo\NasaBundle\Repository\NeoRepository")
 */
class Neo
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="integer")
     */
    private $reference;

    /**
     * @MongoDB\Field(type="date")
     */
    private $date;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $speed;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $is_hazardous;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Neo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     * @return Neo
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        if (is_object($this->date))
            return $this->date->format("Y-m-d");
        else
            return $this->date;
    }

    /**
     * @param mixed string
     * @return Neo
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Neo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param string $speed
     * @return Neo
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsHazardous()
    {
        return $this->is_hazardous;
    }

    /**
     * @param boolean $is_hazardous
     * @return Neo
     */
    public function setIsHazardous($is_hazardous)
    {
        $this->is_hazardous = $is_hazardous;
        return $this;
    }

    /**
     * Convert document properties into an array.
     *
     * @return array
     */
    public function toArray()
    {
        return ["reference" => $this->getReference(), "name" => $this->getName(), "date" => $this->getDate(), "speed" => $this->getSpeed(), "is_hazardous" => $this->getIsHazardous()];
    }
}