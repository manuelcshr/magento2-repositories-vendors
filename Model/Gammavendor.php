<?php
namespace Gamma\Vendor\Model;

class Gammavendor extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Gamma\Vendor\Model\ResourceModel\Gammavendor');
    }
}
?>