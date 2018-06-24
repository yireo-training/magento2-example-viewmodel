<?php
declare(strict_types=1);

namespace Yireo\ExampleViewModel\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Product implements ArgumentInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * Product constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
    ) {

        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
    }

    /**
     * @return ProductInterface[]
     */
    public function getProducts(): array
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $searchCriteriaBuilder->addFilter('name', 't%', 'like');
        $searchCriteriaBuilder->setPageSize(3);
        $searchCriteria = $searchCriteriaBuilder->create();

        $searchResult = $this->productRepository->getList($searchCriteria);
        $products = $searchResult->getItems();

        return $products;
    }
}