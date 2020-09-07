<?php
namespace Bulbulatory\Recomendations\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Customer\Api\CustomerRepositoryInterface;

class RecommenderEmail extends Column
{
    protected $customerRepositoryInterface;

    public function __construct(
        CustomerRepositoryInterface $customerRepositoryInterface,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

public function prepareDataSource(array $dataSource)
{
    if (isset($dataSource['data']['items'])) {
        foreach ($dataSource['data']['items'] as &$item) {
            if ($item['recommender_id']) {
                $recommenderId = $item['recommender_id'];
                $recommender = $this->_customerRepositoryInterface->getById($recommenderId);
                $item['recommender_id'] = $recommender->getEmail();
            } else {
                $item['recommender_id'] = '';
            }
        }
    }
    return $dataSource;
}
} 