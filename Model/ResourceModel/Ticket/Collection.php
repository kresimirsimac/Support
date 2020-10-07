<?php

namespace Iweb\Support\Model\ResourceModel\Ticket;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\Ticket::class, \Iweb\Support\Model\ResourceModel\Ticket::class);
    }
}
