<?php

namespace Gamma\Vendor\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

    
    protected $_factoryGamma;
    protected $_vendorRepositoryInterface;
    protected $_searchCriteriaBuilder;
    
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Gamma\Vendor\Model\ResourceModel\Gammavendor\Collection $factoryGamma,
        \Gamma\Vendor\Api\VendorRepositoryInterface $vendorRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []) {

        $this->_factoryGamma = $factoryGamma;
        $this->_vendorRepositoryInterface = $vendorRepositoryInterface;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function getVendorsList(){
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("info");
        
        
        //return $this->_factoryGamma->addFieldToSelect("*");
        
        $searchCriteria = $this->_searchCriteriaBuilder
        //->addFilter(PickRequestInterface::ORDER_ID, $order->getId())
        ->create();
        
        $data = $this->_vendorRepositoryInterface->getList($searchCriteria);
        $logger->info("getVendorsList: ".print_r(count($data->getItems()),true));
        
        
        return $data->getItems();
    }
    
    

}