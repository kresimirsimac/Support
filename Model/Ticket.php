<?php

namespace Iweb\Support\Model;

class Ticket extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Iweb\Support\Model\ResourceModel\Ticket::class);
    }
}
