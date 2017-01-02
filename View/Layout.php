<?php
/**
 * @author      Sergey Babko <srgbabko@gmail.com>
 * @copyright   © 2017 farior (https://github.com/farior)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Farior\LayoutStructure\View;

class Layout extends \Magento\Framework\View\Layout
{
    /**
     * @return \Magento\Framework\View\Layout\Data\Structure
     */
    public function getStructure()
    {
        return $this->structure;
    }
}
