<?php

namespace Robin\Bai1\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'catalog_product_entity'
         */
        $table_name = $installer->getTable('banner');
        if (!$installer->getConnection()->isTableExists($table_name)) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable($table_name))
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
                )->addColumn(
                    'link',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true]
                )->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT]
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE]
                )->setOption("charset", "utf8");
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
