<?php

namespace Bulbulatory\Recomendations\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Potwierdzony')], 
            ['value' => 0, 'label' => __('Niepotwierdzony')]
        ];
    }
}