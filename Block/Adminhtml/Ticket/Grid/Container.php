<?php

namespace Iweb\Support\Block\Adminhtml\Ticket\Grid;

class Container extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_headerText = __('All Support Tickets');
        
        parent::_construct();
        
        $this->buttonList->remove('add');
    }
}
