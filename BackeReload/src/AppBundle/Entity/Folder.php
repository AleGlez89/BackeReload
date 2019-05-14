<?php

namespace AppBundle\Entity;

class Folder
{
    /**
     * name of file
     */
    protected $name;

    /**
     * create at
     */
    protected $createAt;

    /**
     * list of file or folders
     */
    protected $files;


    public function __construct()
    {
        $this->files = array();
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

    /**
     * Get the value of extension.
     *
     * @return string
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add new file.
     *
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    /**
     * Add new folder.
     *
     * @param Folder $folder
     */
    public function addFolder(Folder $folder)
    {
        $this->files[] = $folder;
    }
}
