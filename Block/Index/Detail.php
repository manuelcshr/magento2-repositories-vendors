<?php

namespace Gamma\Vendor\Block\Index;

class Detail extends \Magento\Framework\View\Element\Template {

    
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
        $this->_coreRegistry = $context->getRegistry();
        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    /**
     * Retrieve current product object
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        if (!$this->hasData('product')) {
            $this->setData('product', $this->_coreRegistry->registry('product'));
        }
        return $this->getData('product');
    }
    
    public function getVendorsList($productId){
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getVendorsList detail");
        
        
        
        $data = $this->_vendorRepositoryInterface->getAssociatedVendors($productId);
        
        
        return $data;
    }
    
    
    

}