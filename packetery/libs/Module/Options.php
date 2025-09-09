<?php
/**
 * 2017 Zlab Solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Eugene Zubkov <magrabota@gmail.com>, RTsoft s.r.o
 *  @copyright 2017 Zlab Solutions
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

namespace Packetery\Module;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Packetery;
use Packetery\Exceptions\SenderGetReturnRoutingException;
use Packetery\Log\LogRepository;
use Packetery\Tools\Tools;

class Options
{
    public const API_PASSWORD_LENGTH = 32;

    /** @var \Packetery */
    private $module;

    /** @var SoapApi */
    private $soapApi;

    /** @var LogRepository */
    private $logRepository;

    public function __construct(
        \Packetery $module,
        SoapApi $soapApi,
        LogRepository $logRepository,
    ) {
        $this->module = $module;
        $this->soapApi = $soapApi;
        $this->logRepository = $logRepository;
    }

    /**
     * @param string $id from POST
     * @param string $value from POST
     *
     * @return false|string false on success, error message on failure
     *
     * @throws Packetery\Exceptions\ApiClientException
     * @throws \ReflectionException
     */
    public function validate($id, $value)
    {
        switch ($id) {
            case 'PACKETERY_APIPASS':
                if (\Tools::strlen($value) !== self::API_PASSWORD_LENGTH) {
                    return $this->module->l('Api password must be 32 characters long.', 'options');
                }

                return false;
            case 'PACKETERY_ESHOP_ID':
                $configHelper = $this->module->diContainer->get(Packetery\Tools\ConfigHelper::class);
                if (!$configHelper->getApiPass()) {
                    // Error for PACKETERY_APIPASS is enough.
                    return false;
                }
                try {
                    $this->soapApi->senderGetReturnRouting($value);
                    $this->logRepository->insertRow(
                        LogRepository::ACTION_SENDER_VALIDATION,
                        [
                            'value' => $value,
                        ],
                        LogRepository::STATUS_SUCCESS
                    );

                    return false;
                } catch (SenderGetReturnRoutingException $e) {
                    if ($e->senderNotExists === true) {
                        return $this->module->l('Provided sender indication does not exist.', 'options');
                    }

                    $this->logRepository->insertRow(
                        LogRepository::ACTION_SENDER_VALIDATION,
                        [
                            'value' => $value,
                            'senderNotExists' => $e->senderNotExists,
                        ],
                        LogRepository::STATUS_ERROR
                    );

                    return sprintf(
                        '%s: %s',
                        $this->module->l('Sender indication validation failed', 'options'),
                        $e->getMessage()
                    );
                }
            case 'PACKETERY_DEFAULT_PACKAGE_PRICE':
                if ($this->isNonNegative($value)) {
                    return false;
                }

                return $this->module->l('Please insert default package price', 'options');
            case 'PACKETERY_DEFAULT_PACKAGE_WEIGHT':
                if ($this->isNonNegative($value)) {
                    return false;
                }

                return $this->module->l('Please insert default package weight in kg', 'options');
            case 'PACKETERY_DEFAULT_PACKAGING_WEIGHT':
                if ($this->isNonNegative($value)) {
                    return false;
                }

                return $this->module->l('Please insert default packaging weight in kg', 'options');
            case 'PACKETERY_PACKET_STATUS_TRACKING_MAX_PROCESSED_ORDERS':
                if ($this->isNonNegative($value)) {
                    return false;
                }

                return $this->module->l('Insert maximum number of orders that will be processed', 'options');
            case 'PACKETERY_PACKET_STATUS_TRACKING_MAX_ORDER_AGE_DAYS':
                if ($this->isNonNegative($value)) {
                    return false;
                }

                return $this->module->l('Insert maximum order age in days', 'options');
            default:
                return false;
        }
    }

    /**
     * @param string $option
     * @param string $value
     *
     * @return string
     */
    public function formatOption($option, $value)
    {
        switch ($option) {
            case 'PACKETERY_DEFAULT_PACKAGE_PRICE':
            case 'PACKETERY_DEFAULT_PACKAGE_WEIGHT':
            case 'PACKETERY_DEFAULT_PACKAGING_WEIGHT':
                return Tools::sanitizeFloatValue($value);
            default:
                return $value;
        }
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isNonNegative($value)
    {
        return \Validate::isUnsignedInt($value) || (\Validate::isFloat($value) && $value >= 0);
    }
}
