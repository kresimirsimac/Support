<?php

namespace Iweb\Support\Controller\Adminhtml\Ticket;

class MassActivate extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $ids = $this->getRequest()->getParam('id');
        
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addErrorMessage(__('Please, select ticket(s) to activate.'));
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get(\Iweb\Support\Model\Ticket::class)->load($id);
                    $row->setStatus('active')
                        ->save();
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 ticket(s) had been activated.', count($ids)));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->_redirect('iweb_support/ticket/index/');
    }
}
