<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class MassDelete extends \Magento\Backend\App\Action
{       
    public function execute()
    {
        $ids = $this->getRequest()->getParam('id');
        
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addErrorMessage(__('Please, select replies to delete.'));
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get(\Iweb\Support\Model\Reply::class)->load($id);
                    $supportId = $row->getSupportId();
                    $row->delete();
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) has been deleted.', count($ids)));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        
        $this->_redirect('iweb_support/ticket/view/', ['support_id' => $supportId]);
    }
}
