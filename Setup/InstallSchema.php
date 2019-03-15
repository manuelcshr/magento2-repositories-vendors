<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_AdminActionLog
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
namespace Gamma\Vendor\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('gamma_vendor'))
            ->addColumn('vendor_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true
                ], 'Id Vendor')
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, "255", [
                'nullable'  => false,
                'default'   => null
                ], 'Nombre');
        $installer->getConnection()->createTable($table);
        
        
        $table = $installer->getConnection()
        ->newTable($installer->getTable('gamma_vendortoproduct'))
        ->addColumn('vendor_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
        ], 'Id Vendor')
        ->addColumn('product_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
        ], 'Id Product')
        ->addForeignKey(
            $setup->getFkName("gamma_vendortoproduct",'vendor_id',$setup->getTable('gamma_vendor'),'vendor_id'),
            'vendor_id',
            $setup->getTable('gamma_vendor'),
            'vendor_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
        ->addForeignKey(
            $setup->getFkName("gamma_vendortoproduct",'product_id',$setup->getTable('catalog_product_entity'),'entity_id'),
            'product_id',
            $setup->getTable('catalog_product_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
