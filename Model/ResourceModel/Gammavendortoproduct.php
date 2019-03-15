<?php
namespace Gamma\Vendor\Model\ResourceModel;

class Gammavendortoproduct extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('gamma_vendortoproduct', 'vendor_id');
    }
    
    
    
}
?>