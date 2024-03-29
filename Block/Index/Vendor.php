<?php

namespace Gamma\Vendor\Block\Index;

class Vendor extends \Magento\Framework\View\Element\Template {

    
    protected $_gammavendorFactory;
    protected $_productRepository;
    
    
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Gamma\Vendor\Model\GammavendorFactory $gammavendorFactory ,
        \Gamma\Vendor\Api\VendorRepositoryInterface $vendorRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []) {

        $this->_gammavendorFactory = $gammavendorFactory;
        $this->_vendorRepositoryInterface = $vendorRepositoryInterface;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_productRepository = $productRepository;
        
        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    
    public function getVendor($idVendor){
        //$factory = $this->_gammavendorFactory->create();
        //return $factory->load($idVendor);
        
        //$searchCriteria = $this->_searchCriteriaBuilder;
       // ->addFilter("vendor_id", $idVendor)
        //->create();
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getVendor block");
        
        $data = $this->_vendorRepositoryInterface->load($idVendor);
        
        
        $logger->info("getVendor block data: ".print_r($data->getData(),true));
        
        return $data;
    }
    
    public function getAssociatedProductcIds($idVendor){
        
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getAssociatedProductcIds block");
        
        
        $dataProducts = $this->_vendorRepositoryInterface->getAssociatedProductcIds($idVendor);
        $dataListProducs = array();
        foreach($dataProducts as $product_){
            $dataListProducs[] = $this->getProductById($product_["entity_id"]);
        }
        
        return $dataListProducs;
    }
    
    private function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }
    
    private function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
    
    

}