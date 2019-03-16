<?php
namespace Gamma\Vendor\Setup;


use Gamma\Vendor\Model\Gammavendor;
use Gamma\Vendor\Model\GammavendorFactory;
use Gamma\Vendor\Model\Gammavendortoproduct;
use Gamma\Vendor\Model\GammavendortoproductFactory;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $vendorFactory;
    private $vendortoproductFactory;
    
    public function __construct(
        GammavendortoproductFactory $vendorFactory,
        GammavendortoproductFactory $vendortoproductFactory
        
        )
    {
        $this->vendorFactory            = $vendorFactory;
        $this->vendortoproductFactory   = $vendortoproductFactory;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("install");
        
        
        $setup->startSetup();
        
        $columns = [];
        $columns = ['vendor_id', 'name'];
        $data = [];
        $data[] = [1, 'Chedraui'];
        $data[] = [2, 'Soriana'];
        $data[] = [3, 'Aurrera'];
        $data[] = [4, 'Walmart'];
        $data[] = [5, 'Sams'];
        
        
        $setup->getConnection()
        ->insertArray($setup->getTable('gamma_vendor'), $columns, $data);
        
        
        
        $columns = [];
        $columns = ['vendor_id', 'product_id'];
        $data = [];
        $data[] = [1, 1];
        $data[] = [1, 2];
        $data[] = [1, 3];
        $data[] = [1, 4];
        $data[] = [1, 5];
        $data[] = [1, 6];
        $data[] = [1, 7];
        $data[] = [2, 1];
        $data[] = [2, 2];
        $data[] = [2, 3];
        $data[] = [2, 4];
        $data[] = [2, 5];
        $data[] = [2, 6];
        $data[] = [3, 1];
        $data[] = [3, 2];
        $data[] = [3, 3];
        $data[] = [3, 4];
        $data[] = [3, 5];
        $data[] = [3, 6];
        $data[] = [3, 7];
        $data[] = [3, 8];
        $data[] = [4, 1];
        $data[] = [4, 3];
        $data[] = [4, 5];
        $data[] = [4, 6];
        $data[] = [4, 9];
        $data[] = [4, 19];
        $data[] = [5, 4];
        $data[] = [5, 5];
        $data[] = [5, 11];
        $data[] = [5, 21];
        $data[] = [5, 31];
        $data[] = [5, 41];
        $data[] = [5, 12];
        
        
        $setup->getConnection()
        ->insertArray($setup->getTable('gamma_vendortoproduct'), $columns, $data);
        
        /**
         * Prepare database after install
         */
        $setup->endSetup();
        
    }
}