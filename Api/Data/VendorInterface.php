<?php

namespace Gamma\Vendor\Api\Data;

interface VendorInterface
{
    
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);
    
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($purchaseOrderId);
    

}