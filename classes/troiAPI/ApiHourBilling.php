<?php
/**
 * Created by PhpStorm.
 * User: lukasbock
 * Date: 19.08.20
 * Time: 22:08
 */

class ApiHourBilling
{
    private $Date;
    private $Service;
    private $id;
    private $Path;
    private $Id;
    private $documentComputedTotalNet;
    private $IsInvoiced;
    private $IsBilled;
    private $IsBillable;
    private $IsDeleted;
    private $Employee;
    private $Remark;
    private $IsApproved;
    private $ETag;
    private $ClassName;
    private $Client;
    private $DisplayPath;
    private $Quantity;
    private $CalculationPosition;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param mixed $Date
     */
    public function setDate($Date): void
    {
        $this->Date = $Date;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->Service;
    }

    /**
     * @param mixed $Service
     */
    public function setService($Service): void
    {
        $this->Service = $Service;
    }

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
     *
     * @return mixed
     */
    public function getBId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $id
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
    public function getDocumentComputedTotalNet()
    {
        return $this->documentComputedTotalNet;
    }

    /**
     * @param mixed $documentComputedTotalNet
     */
    public function setDocumentComputedTotalNet($documentComputedTotalNet): void
    {
        $this->documentComputedTotalNet = $documentComputedTotalNet;
    }

    /**
     * @return mixed
     */
    public function getisInvoiced()
    {
        return $this->IsInvoiced;
    }

    /**
     * @param mixed $IsInvoiced
     */
    public function setIsInvoiced($IsInvoiced): void
    {
        $this->IsInvoiced = $IsInvoiced;
    }

    /**
     * @return mixed
     */
    public function getisBilled()
    {
        return $this->IsBilled;
    }

    /**
     * @param mixed $IsBilled
     */
    public function setIsBilled($IsBilled): void
    {
        $this->IsBilled = $IsBilled;
    }

    /**
     * @return mixed
     */
    public function getisBillable()
    {
        return $this->IsBillable;
    }

    /**
     * @param mixed $IsBillable
     */
    public function setIsBillable($IsBillable): void
    {
        $this->IsBillable = $IsBillable;
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
    public function getEmployee()
    {
        return $this->Employee;
    }

    /**
     * @param mixed $Employee
     */
    public function setEmployee($Employee): void
    {
        $this->Employee = $Employee;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->Remark;
    }

    /**
     * @param mixed $Remark
     */
    public function setRemark($Remark): void
    {
        $this->Remark = $Remark;
    }

    /**
     * @return mixed
     */
    public function getisApproved()
    {
        return $this->IsApproved;
    }

    /**
     * @param mixed $IsApproved
     */
    public function setIsApproved($IsApproved): void
    {
        $this->IsApproved = $IsApproved;
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
    public function getClient()
    {
        return $this->Client;
    }

    /**
     * @param mixed $Client
     */
    public function setClient($Client): void
    {
        $this->Client = $Client;
    }

    /**
     * @return mixed
     */
    public function getDisplayPath()
    {
        return $this->DisplayPath;
    }

    /**
     * @param mixed $DisplayPath
     */
    public function setDisplayPath($DisplayPath): void
    {
        $this->DisplayPath = $DisplayPath;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->Quantity;
    }

    /**
     * @param mixed $Quantity
     */
    public function setQuantity($Quantity): void
    {
        $this->Quantity = $Quantity;
    }

    /**
     * @return mixed
     */
    public function getCalculationPosition()
    {
        return $this->CalculationPosition;
    }

    /**
     * @param mixed $CalculationPosition
     */
    public function setCalculationPosition($CalculationPosition): void
    {
        $this->CalculationPosition = $CalculationPosition;
    } //ApiSyncItem



}