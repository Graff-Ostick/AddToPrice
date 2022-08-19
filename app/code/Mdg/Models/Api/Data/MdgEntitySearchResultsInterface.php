<?php
declare(strict_types=1);

namespace Mdg\Models\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for mdg entity search results.
 * @api
 * @since 100.0.2
 */
interface MdgEntitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get mdg entity list.
     *
     * @return \Mdg\Models\Api\Data\MdgEntityInterface[]
     */
    public function getItems();

    /**
     * Set mdg entity list.
     *
     * @param \Mdg\Models\Api\Data\MdgEntityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
