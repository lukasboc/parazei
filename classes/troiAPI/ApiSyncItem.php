<?php
/**
 * Created by PhpStorm.
 * User: lukasbock
 * Date: 19.08.20
 * Time: 21:11
 */

class ApiSyncItem
{
    private $id;
    private $Path;
    private $Id;
    private $ReeProjectId;
    private $ReeQuantity;
    private $ParentPath;
    private $IsDeleted;
    private $ReeSubProjectId;
    private $ReeServiceId;
    private $IsPrintable;
    private $IsFavorite;
    private $ReeDate;
    private $ReeEmployeeId;
    private $ETag;
    private $Name;
    private $ClassName;
    private $ReeCpId;
    private $Type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getBId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setBId($id): void
    {
        $this->Id = $id;
    }


    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->Path;
    }

    /**
     * @param mixed $Path
     */
    public function setPath($Path): void
    {
        $this->Path = $Path;
    }

    /**
     * @return mixed
     */
    public function getReeProjectId()
    {
        return $this->ReeProjectId;
    }

    /**
     * @param mixed $ReeProjectId
     */
    public function setReeProjectId($ReeProjectId): void
    {
        $this->ReeProjectId = $ReeProjectId;
    }

    /**
     * @return mixed
     */
    public function getReeQuantity()
    {
        return $this->ReeQuantity;
    }

    /**
     * @param mixed $ReeQuantity
     */
    public function setReeQuantity($ReeQuantity): void
    {
        $this->ReeQuantity = $ReeQuantity;
    }

    /**
     * @return mixed
     */
    public function getParentPath()
    {
        return $this->ParentPath;
    }

    /**
     * @param mixed $ParentPath
     */
    public function setParentPath($ParentPath): void
    {
        $this->ParentPath = $ParentPath;
    }

    /**
     * @return mixed
     */
    public function getisDeleted()
    {
        return $this->IsDeleted;
    }

    /**
     * @param mixed $IsDeleted
     */
    public function setIsDeleted($IsDeleted): void
    {
        $this->IsDeleted = $IsDeleted;
    }

    /**
     * @return mixed
     */
    public function getReeSubProjectId()
    {
        return $this->ReeSubProjectId;
    }

    /**
     * @param mixed $ReeSubProjectId
     */
    public function setReeSubProjectId($ReeSubProjectId): void
    {
        $this->ReeSubProjectId = $ReeSubProjectId;
    }

    /**
     * @return mixed
     */
    public function getReeServiceId()
    {
        return $this->ReeServiceId;
    }

    /**
     * @param mixed $ReeServiceId
     */
    public function setReeServiceId($ReeServiceId): void
    {
        $this->ReeServiceId = $ReeServiceId;
    }

    /**
     * @return mixed
     */
    public function getisPrintable()
    {
        return $this->IsPrintable;
    }

    /**
     * @param mixed $IsPrintable
     */
    public function setIsPrintable($IsPrintable): void
    {
        $this->IsPrintable = $IsPrintable;
    }

    /**
     * @return mixed
     */
    public function getisFavorite()
    {
        return $this->IsFavorite;
    }

    /**
     * @param mixed $IsFavorite
     */
    public function setIsFavorite($IsFavorite): void
    {
        $this->IsFavorite = $IsFavorite;
    }

    /**
     * @return mixed
     */
    public function getReeDate()
    {
        return $this->ReeDate;
    }

    /**
     * @param mixed $ReeDate
     */
    public function setReeDate($ReeDate): void
    {
        $this->ReeDate = $ReeDate;
    }

    /**
     * @return mixed
     */
    public function getReeEmployeeId()
    {
        return $this->ReeEmployeeId;
    }

    /**
     * @param mixed $ReeEmployeeId
     */
    public function setReeEmployeeId($ReeEmployeeId): void
    {
        $this->ReeEmployeeId = $ReeEmployeeId;
    }

    /**
     * @return mixed
     */
    public function getETag()
    {
        return $this->ETag;
    }

    /**
     * @param mixed $ETag
     */
    public function setETag($ETag): void
    {
        $this->ETag = $ETag;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->ClassName;
    }

    /**
     * @param mixed $ClassName
     */
    public function setClassName($ClassName): void
    {
        $this->ClassName = $ClassName;
    }

    /**
     * @return mixed
     */
    public function getReeCpId()
    {
        return $this->ReeCpId;
    }

    /**
     * @param mixed $ReeCpId
     */
    public function setReeCpId($ReeCpId): void
    {
        $this->ReeCpId = $ReeCpId;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type): void
    {
        $this->Type = $Type;
    }

}