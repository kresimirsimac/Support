<?php

namespace Iweb\Support\Model\ResourceModel\View;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\View::class, \Iweb\Support\Model\ResourceModel\View::class);
    }
}
