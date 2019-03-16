<?php

namespace Gamma\Vendor\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Gamma\Vendor\Api\VendorRepositoryInterface;
use Gamma\Vendor\Api\Data\VendorSearchResultsInterfaceFactory;
use Gamma\Vendor\Api\Data\VendorInterface;
use Gamma\Vendor\Model\ResourceModel\Gammavendor as VendorResource;
use Gamma\Vendor\Model\ResourceModel\Gammavendor\CollectionFactory as CollectionFactory;
use Gamma\Vendor\Model\ResourceModel\Gammavendor\Collection as Collection;


class VendorRepository implements VendorRepositoryInterface
{
    
    /**
     * @var vendorResource
     */
    protected $vendorResource;

    /**
     * @var VendorFactory
     */
    protected $vendorFactory;
    
    /**
     * @var CollectionFactory
     */
    protected $vendorCollectionFactory;

    /**
     * @var VendorSearchResultsInterfaceFactory
     */
    protected $searchResultFactory;
    
    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;

    public function __construct(
        VendorResource $vendorResource,
        VendorFactory $vendorFactory,
        CollectionFactory $vendorCollectionFactory,
        VendorSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->vendorResource = $vendorResource;
        $this->vendorFactory = $vendorFactory;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
        $this->searchResultFactory = $searchResultsFactory;
        $this->_dataObjectHelper = $dataObjectHelper;
    }
    
    public function load($id){
        $vendor = $this->vendorFactory->create();
        $vendor->getResource()->load($vendor, $id);
        if (! $vendor->getId()) {
            throw new NoSuchEntityException(__('Unable to find vendor with ID "%1"', $id));
        }
        return $vendor;
    }

    public function save(VendorInterface $vendor){
        $vendor->getResource()->save($vendor);
        return $vendor;
    }

    public function getList(SearchCriteriaInterface $searchCriteria){
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getList");
        
        /** @var \Gamma\Vendor\Api\Data\DataSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        
        /** @var \Gamma\Vendor\Model\ResourceModel\Data\Collection $collection */
        $collection = $this->vendorCollectionFactory->create();
        $logger->info("getList2");
        
        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        
        $logger->info("getList3");
        
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                    );
            }
        } else {
            $field = 'vendor_id';
            $collection->addOrder($field, 'ASC');
        }
        
        $logger->info("getList4");
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        
        $logger->info("getList5: size: ".$collection->getSize());
        
        $data = [];
        foreach ($collection as $datum) {
            
            $logger->info("getList5.1");
            
            $dataDataObject = $this->vendorFactory->create();
            
            $logger->info("getList5.2: ".print_r($datum->getData(),true));
            try{
                $this->_dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), VendorInterface::class);
            }catch (\Exception $e){
                $logger->info("getList exception: ".$e->getMessage());
            }
            $logger->info("getList5.3 : ");
            
            $data[] = $dataDataObject;
            
            $logger->info("getList5.4");
        }
        
        $logger->info("getList6");
        $searchResults->setTotalCount($collection->getSize());
        
        $logger->info("getList7: ".get_class($searchResults));
        return $searchResults->setItems($data);
        
        
        
        /*
        
        
        try{
            $collection = $this->vendorCollectionFactory->create();
        }catch (\Exception $e){
            $logger->info("getList exception: ".$e->getMessage());
        }
        
        $logger->info("getList 2");
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
        */
    }
    
    /**
     * @param int $vendorId
     * @return array
     */
    public function getAssociatedProductcIds($vendorId)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getAssociatedProductcIds repository");
        
        $productIds = $this->vendorResource
        ->getAssociatedProductIds($vendorId);
        
        $logger->info("getAssociatedProductcIds productIds: ".print_r($productIds,true));
        
        return $productIds;
        
    }
    
    
    /**
     * @param int $vendorId
     * @return array
     */
    public function getAssociatedVendors($productId)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("getAssociatedVendors repository");
        
        $vendors = $this->vendorResource
        ->getAssociatedVendors($productId);
        
        $logger->info("getAssociatedVendors productIds: ".print_r($vendors,true));
        
        return $vendors;
        
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection){
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection){
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection){
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection){

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        
        $logger->info("buildSearchResult");

        $searchResults = $this->searchResultFactory;

        $logger->info("colleciotns: ".$collection->getSize());
        
        $searchResults->setSearchCriteria($searchCriteria);
        $logger->info("colleciotns:1 ".$collection->getSize());
        
        $searchResults->setItems($collection->getItems());
        
        $logger->info("colleciotns:2 ".$collection->getSize());
        $searchResults->setTotalCount($collection->getSize());
        
        $logger->info("colleciotns:3 ".$collection->getSize());

        
        
        return $searchResults;
    }
    
}