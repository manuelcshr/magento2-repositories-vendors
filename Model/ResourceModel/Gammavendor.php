<?php
namespace Gamma\Vendor\Model\ResourceModel;

class Gammavendor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('gamma_vendor', 'vendor_id');
    }

    public function addRelations($data)
    {
        $this->getConnection()->insertMultiple('gamma_vendortoproduct', $data);
    }

    public function getAssociatedProductIds($vendorId)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info("getAssociatedProductIds gammavendor: ");

        $select = $this->getConnection()->select();

        $select->from([
            'v2p' => 'gamma_vendortoproduct'
        ], 'product_id')->where('vendor_id=?', $vendorId)
        
        ->join(
            ['cpe' => 'catalog_product_entity'],
            'cpe.entity_id=v2p.product_id'
            )
        ;
        $logger->info("getAssociatedProductIds select: " . $select);
        
        $data = $this->getConnection()->fetchAssoc($select);
        
        $logger->info("getAssociatedProductIds data: " . print_r($data,true));

        return $data;
    }
    
    
    public function getAssociatedVendors($productId)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $logger->info("getAssociatedProductIds gammavendor: ");
        
        $select = $this->getConnection()->select();
        
        $select->from([
            'v2p' => 'gamma_vendortoproduct'
        ], 'vendor_id')->where('product_id=?', $productId)
        
        ->join(
            ['gv' => 'gamma_vendor'],
            'gv.vendor_id=v2p.vendor_id'
            )
            ;
        $logger->info("getAssociatedVendors select: " . $select);
        
        $data = $this->getConnection()->fetchAssoc($select);
        
        $logger->info("getAssociatedVendors data: " . print_r($data,true));
        
        return $data;
    }
}
?>