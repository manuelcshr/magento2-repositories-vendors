<?php
namespace Gamma\Vendor\Api;

/**
 *
 * @api
 */
interface VendorRepositoryInterface
{

    /**
     * Get a vendor by id.
     *
     * @param int $id
     * @return \Gamma\Vendor\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function load($id);

    /**
     * Update or new Vendor
     *
     * @param \Gamma\Vendor\Api\Data\VendorInterface $vendor
     * @return \Gamma\Vendor\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Gamma\Vendor\Api\Data\VendorInterface $vendor);

    /**
     * Get list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Gamma\Vendor\Api\Data\VendorSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Get list products
     *
     * @param int $vendorId
     * @return array
     */
    public function getAssociatedProductcIds($vendorId);
    
    /**
     * Get list vendors
     *
     * @param int $producId
     * @return array
     */
    public function getAssociatedVendors($productId);
    
    
}