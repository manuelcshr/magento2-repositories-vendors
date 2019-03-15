<?php

namespace Gamma\Vendor\Model\ResourceModel\Gammavendortoproduct;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Gamma\Vendor\Model\Gammavendortoproduct', 'Gamma\Vendor\Model\ResourceModel\Gammavendortoproduct');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>