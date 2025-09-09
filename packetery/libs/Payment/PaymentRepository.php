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
 *  @copyright Since 2017 Zlab Solutions
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

namespace Packetery\Payment;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Packetery\Exceptions\DatabaseException;
use Packetery\Order\OrderRepository;
use Packetery\Tools\DbTools;

class PaymentRepository
{
    /** @var \Db */
    private $db;

    /** @var DbTools */
    private $dbTools;

    /** @var OrderRepository */
    private $orderRepository;

    /**
     * PaymentRepository constructor.
     *
     * @param \Db $db
     * @param DbTools $dbTools
     * @param OrderRepository $orderRepository
     */
    public function __construct(\Db $db, DbTools $dbTools, OrderRepository $orderRepository)
    {
        $this->db = $db;
        $this->dbTools = $dbTools;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param string $moduleName
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    public function existsByModuleName($moduleName)
    {
        $result = $this->dbTools->getValue(
            'SELECT 1 FROM `' . _DB_PREFIX_ . 'packetery_payment`
            WHERE `module_name` = "' . $this->db->escape($moduleName) . '"'
        );

        return (int) $result === 1;
    }

    /**
     * @param string $paymentModuleName
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    public function isCod($paymentModuleName)
    {
        $isCod = $this->dbTools->getValue(
            'SELECT `is_cod` FROM `' . _DB_PREFIX_ . 'packetery_payment`
            WHERE `module_name` = "' . $this->db->escape($paymentModuleName) . '"'
        );

        return (int) $isCod === 1;
    }

    /**
     * @param int $value
     * @param string $moduleName
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    public function setCod($value, $moduleName)
    {
        $value = (int) $value;

        return $this->dbTools->update('packetery_payment', ['is_cod' => $value], '`module_name` = "' . $this->db->escape($moduleName) . '"');
    }

    /**
     * @param int $value
     * @param string $moduleName
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    public function setOrInsert($value, $moduleName)
    {
        if ($this->existsByModuleName($moduleName)) {
            return $this->setCod($value, $moduleName);
        }

        return $this->insert($value, $moduleName);
    }

    /**
     * @param int $isCod
     * @param string $moduleName
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    public function insert($isCod, $moduleName)
    {
        $isCod = (int) $isCod;

        return $this->dbTools->insert(
            'packetery_payment',
            [
                'is_cod' => $isCod,
                'module_name' => $this->db->escape($moduleName),
            ]
        );
    }

    /**
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws DatabaseException
     */
    public function getAll()
    {
        return $this->dbTools->getRows('SELECT DISTINCT `module_name`, `is_cod` FROM `' . _DB_PREFIX_ . 'packetery_payment`');
    }

    /**
     * Converts price from order currency to branch currency
     *
     * @param string $orderCurrencyIso
     * @param string $branchCurrencyIso
     * @param float|int $total
     *
     * @return float|int|null returns null if rate was not found
     *
     * @throws DatabaseException
     */
    public function getRateTotal($orderCurrencyIso, $branchCurrencyIso, $total)
    {
        $conversionRateOrder = $this->orderRepository->getConversionRate($orderCurrencyIso);
        $conversionRateBranch = $this->orderRepository->getConversionRate($branchCurrencyIso);

        if ($conversionRateBranch) {
            $conversionRate = $conversionRateBranch / $conversionRateOrder;

            return round($conversionRate * $total, 2);
        }

        return null;
    }

    /**
     * Get list of payments for configuration
     *
     * @return array
     *
     * @throws DatabaseException
     */
    public function getListPayments()
    {
        $installedPaymentModules = \PaymentModule::getInstalledPaymentModules();
        $packeteryPaymentConfig = $this->getAll();
        $paymentModules = [];
        if ($packeteryPaymentConfig) {
            $paymentModules = array_column($packeteryPaymentConfig, 'is_cod', 'module_name');
        }

        $payments = [];
        foreach ($installedPaymentModules as $installedPaymentModule) {
            $instance = \Module::getInstanceByName($installedPaymentModule['name']);
            if ($instance === false) {
                continue;
            }
            $is_cod = (
                array_key_exists(
                    $installedPaymentModule['name'],
                    $paymentModules
                ) ? (int) $paymentModules[$installedPaymentModule['name']] : 0
            );
            $payments[] = [
                'name' => $instance->displayName,
                'is_cod' => $is_cod,
                'module_name' => $installedPaymentModule['name'],
            ];
        }

        return $payments;
    }
}
