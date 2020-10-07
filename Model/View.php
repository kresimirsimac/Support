<?php

namespace Iweb\Support\Model;

class View extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\ResourceModel\View::class);
    }
}
