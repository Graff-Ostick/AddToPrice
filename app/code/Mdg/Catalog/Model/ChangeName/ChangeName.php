<?php
declare(strict_types=1);

namespace Mdg\Catalog\Model\ChangeName;

/**
 * Check name product and edit it
 */
class ChangeName
{
    /**
     * @param $name
     * @param $prefix
     * @return string
     */
    public function changeName($name, $prefix):string
    {
        if (strpos($name, $prefix)) {
            return $name;
        }
        return $name . $prefix;
    }
}
