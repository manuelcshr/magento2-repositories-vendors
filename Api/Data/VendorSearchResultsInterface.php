<?php

namespace Gamma\Vendor\Api\Data;

interface VendorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get vendor list.
     *
     * @return \Gamma\Vendor\Api\Data\VendorInterface[]
     */
    public function getItems();

    /**
     * Set vendor list.
     *
     * @param \Gamma\Vendor\Api\Data\VendorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}