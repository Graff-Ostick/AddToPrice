<?php
declare(strict_types=1);

namespace Mdg\Models\Model;

use Magento\Framework\Api\SearchResults;
use Mdg\Models\Api\Data\MdgEntitySearchResultsInterface;

class MdgEntitySearchResult extends SearchResults implements MdgEntitySearchResultsInterface
{

}
