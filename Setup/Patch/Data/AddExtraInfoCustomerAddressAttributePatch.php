<?php
/**
 * @copyright Copyright (c) sbdevblog https://www.sbdevblog.com)
 */

declare(strict_types=1);

namespace SbDevBlog\Customer\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Psr\Log\LoggerInterface;

/**
 * Class extra information customer address attribute create
 */
class AddExtraInfoCustomerAddressAttributePatch implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private CustomerSetupFactory $customerSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param LoggerInterface $logger
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        LoggerInterface $logger
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function apply()
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $attributesInfo = [
            'extra_info_demo' => [
                'label' => 'Extra Information For Demo Address',
                'type'             => 'varchar',
                'input'            => 'text',
                'visible'          => true,
                'required'         => false,
                'user_defined'     => true,
                'system'           => false,
                'group'            => 'General',
                'global'           => true,
                'visible_on_front' => false,
            ],
            //You may add your new attributes in array
        ];

        foreach ($attributesInfo as $attributeCode => $attributeParams) {
            try {
                $customerSetup->addAttribute('customer_address', $attributeCode, $attributeParams);
                $extraInfoAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address', $attributeCode);

                $extraInfoAttribute->setData(
                    'used_in_forms',
                    ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
                );
                $extraInfoAttribute->save();
            } catch (LocalizedException|\Zend_Validate_Exception|\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getVersion()
    {
        return '2.0.0';
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
