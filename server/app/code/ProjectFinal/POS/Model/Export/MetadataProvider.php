<?php


namespace ProjectFinal\POS\Model\Export;

use Magento\Framework\Api\Search\DocumentInterface;

/**
 * Class MetadataProvider rewrite function getRowData to export status with label
 */
class MetadataProvider extends \Magento\Ui\Model\Export\MetadataProvider
{
    const STATUS_PENDING = "Disable";
    const STATUS_ACTIVE = "Enabled";

    /**
     * Method getRowData custom status value when export
     *
     * @param DocumentInterface $document
     * @param array $fields
     * @param array $options
     * @return array
     */
    public function getRowData(DocumentInterface $document, $fields, $options)
    {
        $row = [];
        $key = array_search('status', $fields);
        foreach ($fields as $column) {
            if (isset($options[$column])) {
                $key = $document->getCustomAttribute($column)->getValue();
                if (isset($options[$column][$key])) {
                    $row[] = $options[$column][$key];
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = $document->getCustomAttribute($column)->getValue();
                if ($column == 'status') {
                    switch ($row[$key]) {
                        case 0:
                            $row[$key] = self::STATUS_PENDING;
                            break;
                        case 1:
                            $row[$key] = self::STATUS_ACTIVE;
                            break;
//                        case 2:
//                            $row[$key] = self::STATUS_INACTIVE;
//                            break;
//                        case 3:
//                            $row[$key] = self::STATUS_DISAPPROVED;
//                            break;
//                        case 4:
//                            $row[$key] = self::STATUS_VACATION_MODE;
//                            break;
//                        case 5:
//                            $row[$key] = self::STATUS_CLOSED;
//                            break;
                    }
                }
            }
        }
        return $row;
    }
}
