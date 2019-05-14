<?php

namespace AppBundle\Entity;

use DateTime;

class File
{
    /**
     * name of file
     */
    protected $name;

    /**
     * extension ("gif", "jpg", "jpeg", "png", "txt", "pdf")
     */
    protected $extension;

    /**
     * file description
     */
    protected $description;

    /**
     * create at
     */
    protected $createAt;


    public function __construct()
    {
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the value of extension.
     *
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of createAt.
     *
     * @return string
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set the value of createAt.
     *
     * @param DateTime $createAt
     */
    public function setCreateAt(DateTime $createAt)
    {
        $this->createAt = $createAt;
    }
}
