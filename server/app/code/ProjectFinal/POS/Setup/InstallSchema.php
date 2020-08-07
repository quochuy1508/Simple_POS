<?php


namespace ProjectFinal\POS\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    /**
     * @inheritDoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Create table 'student'
         */
        $setup->startSetup();
        $tableName = $setup->getTable('pos_staff');
        $table = $setup->getConnection()->newTable($tableName);

        $table->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'pos staff ID'
        )
            ->addColumn(
                'username',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'username Staff'
            )->addColumn(
                'password',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'Password Staff'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'Email Staff'
            )->addColumn(
                'telephone',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                ['nullable' => false],
                'Telephone Staff'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => true],
                'Email Staff'
            )->setComment("Staff table");
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}
