<?php

namespace Gamma\Vendor\Model;

use Magento\Framework\Model\AbstractModel;
use Gamma\Vendor\Api\Data\VendorInterface;

class Vendor extends AbstractModel implements VendorInterface
{
    const VENDORID = 'vendor_id';
    const NAME = 'name';
    const ASOCIATEPRODUCS = 'product_id';

    protected function _construct()
    {
        $this->_init("Gamma\Vendor\Model\ResourceModel\Gammavendor");
    }
    
    public function setVendorId($vendorId){
        $this->setData(self::VENDORID,$vendorId);
    }
    
    public function getVendorId(){
        return $this->getData(self::VENDORID);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    public function setAssociatedProductcIds(array $productInterfaceList){
        
        
        
        
        //$this->setData(self::ASOCIATEPRODUCS, $productInterfaceList);
    }

    /*
    public function getAssociatedProductcIds($vendorId){
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getAssociatedProductcIds MODEL");
        return $this->getData(self::ASOCIATEPRODUCS);
    }*/
    
    public function getAssociatedProductIds($vendorId)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $logger->info("getAssociatedProductcIds MODEL");
        
        
        $select = $this->getConnection()->select();
        
        $select->from(
            ['v2p' => 'gamma_vendortoproduct'],
            'product_id'
            )
            ->where('vendor_id=?', $vendorId);
            
            $logger->info("getAssociatedProductIds select: ".$select->getSelect());
            
            
            
            return $this->getConnection()->fetchCol($select);
    }

}