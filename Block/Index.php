<?php

namespace Iweb\Support\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    public function getNewTicketUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/newticket');
    }
    
    public function getPostActionUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/newticketpost');
    }
    
    public function getTicketListUrl()
    {
        return $this->_urlBuilder->getUrl('support/ticket/ticketlist');
    }
    
    public function getBackUrl()
    {
        return $this->_urlBuilder->getUrl('support/page/index');
    }
    
}
