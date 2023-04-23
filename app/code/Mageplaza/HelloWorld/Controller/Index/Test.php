<?php

namespace Mageplaza\HelloWorld\Controller\Index;

class Test extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $textDisplay = new \Magento\Framework\DataObject(array('text' => 'Mageplaza'));
        echo "before dispatch";
        echo "<br>";
        echo $textDisplay->getText();
        echo "<br>";
        $this->_eventManager->dispatch('mageplaza_helloworld_display_text', ['mp_text' => $textDisplay]);
        echo "after dispatch";
        echo "<br>";
        echo $textDisplay->getText();
        echo "<br>";
        echo "done";
        exit;
    }
}
