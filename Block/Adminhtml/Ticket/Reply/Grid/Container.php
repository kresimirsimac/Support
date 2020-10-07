<?php

namespace Iweb\Support\Block\Adminhtml\Ticket\Reply\Grid;

class Container extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_headerText     = __('Replies');        
        
        parent::_construct();
        
        $this->buttonList->remove('add');
    }
}
