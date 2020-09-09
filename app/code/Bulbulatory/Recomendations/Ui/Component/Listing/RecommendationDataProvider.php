<?php

namespace Bulbulatory\Recomendations\Ui\Component\Listing;

class RecommendationDataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    protected function _initSelect()
    {
        $this->addFilterToMap('recommender_email', 'secondTable.email');
        $this->addFilterToMap('created_at', 'main_table.created_at');
        $this->addFilterToMap('email', 'main_table.email');
        
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            [
                'secondTable' => $this->getTable('customer_entity')
            ], 
            'main_table.recommender_id = secondTable.entity_id', 
            [
                'email as recommender_email'
            ]
        );

        return $this;
    }
}