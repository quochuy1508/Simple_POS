<?php


namespace ProjectFinal\POS\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{

    /**
     * @inheritDoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('pos_staff'),
                'name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 50,
                    'nullable' => false,
                    'comment' => 'Name Staff'
                ]
            );
        }
        $setup->endSetup();
    }
}
