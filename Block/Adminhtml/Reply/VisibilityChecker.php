<?php

namespace Iweb\Support\Block\Adminhtml\Reply;

use Magento\Backend\Block\Widget\Grid\Massaction\VisibilityCheckerInterface;
use Magento\Framework\App\State;

class VisibilityChecker implements VisibilityCheckerInterface
{
    private $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function isVisible()
    {
        return $this->state->getMode() !== State::MODE_PRODUCTION;
    }
}
