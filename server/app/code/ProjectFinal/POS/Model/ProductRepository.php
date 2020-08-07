<?php


namespace ProjectFinal\POS\Model;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory;
use Magento\Catalog\Model\ProductFactory;
use ProjectFinal\POS\Api\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

    const WEBPOS_VISBLE = 1;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ProductSearchResultsInterfaceFactory
     */
    protected $productSearchResultsInterfaceFactory;

    /**
     * @var ProductInterfaceFactory
     */
    protected $productInterfaceFactory;

    /**
     * @var ProductFactory
     */
    protected $productFactory;


    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;
    /**
     *
     * /**
     * @var \Magento\Catalog\Api\ProductAttributeRepositoryInterface
     */
    protected $metadataService;


    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;


    protected $listAttributes = [
        "entity_id",
        "type_id",
        "category_ids",
        "description",
        "has_options",
        "image",
        "small_image",
        "name",
        "price",
        "sku",
        "special_from_date",
        "special_to_date",
        "status",
        "weight",
        "updated_at"
    ];

    /**
     * @param CollectionFactory $collectionFactory ,
     * @param ProductSearchResultsInterfaceFactory $productSearchResultsInterfaceFactory
     * @param ProductInterfaceFactory $productInterfaceFactory ,
     * @param ProductFactory $productFactory
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ProductAttributeRepositoryInterface $metadataServiceInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ProductSearchResultsInterfaceFactory $productSearchResultsInterfaceFactory,
        ProductInterfaceFactory $productInterfaceFactory,
        ProductFactory $productFactory,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ProductAttributeRepositoryInterface $metadataServiceInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->productSearchResultsInterfaceFactory = $productSearchResultsInterfaceFactory;
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->productFactory = $productFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->metadataService = $metadataServiceInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        $searchResults = $this->productSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect("*")->addAttributeToSelect("*");
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
//        ->addAttributeToFilter("webpos_visible", ["eq"=>"1"]);

        $this->addFilterToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();
        $result = [];
        foreach ($collection->addMediaGalleryData() as $product){
            $temp = [];
            if($product->getTypeId() == "configurable"){
                $children = $product->getTypeInstance()->getUsedProducts($product);
                if(!empty($children)){

                    foreach ($children as $child){
                        $attrColor = $product->getResource()->getAttribute('color');
                        $attrSize = $product->getResource()->getAttribute('size');
                        if ($attrColor->usesSource() && $attrSize->usesSource()) {
                            $optionTextColor = $attrColor->getSource()->getOptionText($child["color"]);
                            $attributeIdColor = $attrColor->getSource()->getAttribute()->getAttributeId();
                            $optionTextSize = $attrSize->getSource()->getOptionText($child["size"]);
                            $attributeIdSize = $attrSize->getSource()->getAttribute()->getAttributeId();
                            $temp[] = array(
                              "entity_id" => $child->getEntityId(),
                                "type_id" => $child->getTypeId(),
                                "sku" => $child->getSku(),
                                "name" => $child->getName(),
                                "color" => array(
                                    "option_id" => $attributeIdColor,
                                    "label" => $optionTextColor,
                                    "option_value" => $child["color"]
                                ),
                                "size" => array(
                                    "option_id" => $attributeIdSize,
                                    "label" => $optionTextSize,
                                    "option_value" => $child["size"]
                                ),
                            );
                        }
                    }
                }
            }
            $result[] = array(
                "id" => $product->getId(),
                "name" => $product->getName(),
                "image" => $product->getMediaGalleryImages()->getColumnValues("url")[0],
                "sku" => $product->getSku(),
                "price" => $product->getFinalPrice(),
                "store_id" => $product->getStoreId(),
                "visibility" => $product->getVisibility(),
                "status" => $product->getStatus(),
                "category" => $product->getCategory(),
                "weight" => $product->getWeight(),
                "type_id" => $product->getTypeId(),
                "childItems" => $temp
            );
        }
        $searchResults->setItems($result);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    private function addFilterToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {

            $fields = [];
            $categoryFilter = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $conditionType = $filter->getConditionType() ?: 'eq';

                if ($filter->getField() == 'category_id') {
                    $categoryFilter[$conditionType][] = $filter->getValue();
                    continue;
                }
                $fields[] = ['attribute' => $filter->getField(), $conditionType => $filter->getValue()];
            }

            if ($categoryFilter) {
                $collection->addCategoriesFilter($categoryFilter);
            }

            if ($fields) {
                $collection->addFieldToFilter($fields);
            }
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

}
