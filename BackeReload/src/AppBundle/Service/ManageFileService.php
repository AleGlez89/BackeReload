<?php

namespace AppBundle\Service;

use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use Exception;

/**
 * @Service("manage.file.service")
 */
class ManageFileService
{
    protected $APCService;
    protected $cacheKey = '';

    /**
     * @InjectParams({
     *     "APCService" = @Inject("apc.service"),
     * })
     * @param APCService $APCService
     */
    public function __construct(
        APCService $APCService
    )
    {
        $this->$APCService = $APCService;
        $this->cacheKey = 'folder_storage';
    }

    /**
     * @param  array  $fileData
     *
     * @return boolean
     */
    public function createFile($fileData)
    {
        $file = new File();
        $file->setName($fileData['name']);
        if (isset($fileData['description']))
            $file->setDescription($fileData['description']);
        $file->setCreateAt(date("Y-m-d H:i:s"));

        return $file;
    }

    /**
     * @param  array  $folderData
     *
     * @return Folder
     */
    public function createFolder($folderData)
    {
        $folder = new Folder();
        $folder->setName($folderData['name']);
        $folder->setCreateAt(date("Y-m-d H:i:s"));

        return $folder;
    }

    /**
     * @param  array  $folder
     *
     * @return boolean
     */
    public function saveFilesAPC($folder)
    {
        $this->APCService->store($this->cacheKey, $folder);
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function getFilesAPC()
    {
        $success = true;
        $folders = $this->APCService->fetch($this->cacheKey, $success);

        if ($success) {
            return $folders;
        }

        throw new Exception("Fail to get files");
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function getFiles()
    {
        $File = new Folder();
        return $File ->getFiles();

    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function moveFiles($obj)
    {
         $Folder = new Folder();
        $Folder2 = new Folder();
        $File = new File();
        $FolderP = array();
        $ControlDelete = false;

        $ArrayFolder [] = $Folder->getFiles();                //Logica similar, dudas sobre el getfiles....
        foreach ($ArrayFolder as $value) {
            if ($value == $obj->ObjFatherOrigen) {
                array_push($FolderP,$value);
                $ArrayFile [] = $FolderP [0]->getFiles();
                foreach ($ArrayFile as $value) {
                    if ($value == $obj->ObjChil) {
                        $ControlDelete = true;
                        $File = $value;
                        $var = $this->deleteFiles($File);
                    }
                }
            } else if ($value == $obj->ObjFatherDestino) {
                $Folder2 = $value;
            }
        }
        $Folder2->addFile($File);
        return $ControlDelete;
    }

       /* $ArrayFolder = $Folder->getFiles();                           //All Folders (search father)
        if ($index = array_search($obj->ObjFatherOri,$ArrayFolder))     //Search folder in list folder
        {
            $Folder = $ArrayFolder[$index];                          //Folder the File to Move
            $ArrayFile = $Folder->getFiles();                       //All Files the Folder
            if ($index = array_search($obj->ObjChil,$ArrayFile))    //Search file in list file
            {
                $File = $ArrayFile[$index];
                unset($ArrayFile[$index]);                           //Se pudiera llamar al eliminar de esta clase, pero me a dudas sobre si coge el list file o folder
            } else {
                $ControlDelete = true;                              //Variable de control por si no existe el elemento hijo
            }
        } else {
            $ControlDelete = true;                                 //Variable de control por si no existe el elemento padre
        }

        $ArrayFolder = $Folder->getFiles();                          //All Folders (search new father)
        if ($index = array_search($obj->ObjFatherDes,$ArrayFolder))
        {
            $Folder = $ArrayFolder[$index];                          //Folder the File to Move
            $Folder ->addFile($File);                                //Save new file in the list file the new Folder Father
        } else {
            $ControlDelete = true;                                 //Variable de control por si no existe el elemento padreNew
        }
        return $ControlDelete;
    }*/


    /**
     * @return array
     *
     * @throws Exception
     */
    public function deleteFiles($obj)
    {
        $File = new Folder();
        $ControlDelete = false;
        $ArrayFile = $File ->getFiles();
        $index = array_search($obj,$ArrayFile);
        if ($index)
        {
            $ControlDelete = true;
            unset($ArrayFile[$index]);
        }
        return $ControlDelete;
    }
}