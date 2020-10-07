<?php

namespace Iweb\Support\Controller\Adminhtml\Reply;

class MassHide extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $ids = $this->getRequest()->getParam('id');
        
        if (!is_array($ids) || empty($ids)) {
            $this->messageManager->addErrorMessage('Please, select replies to edit visibility.');
        } else {
            try {
                foreach ($ids as $id) {
                    $row = $this->_objectManager->get(\Iweb\Support\Model\Reply::class)->load($id);
                    $supportId = $row->getSupportId();
                    $row->setVisible('hidden')
                        ->save();
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) had been hidden.', count($ids)));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->_redirect('iweb_support/ticket/view/', ['support_id' => $supportId]);
    }
}
