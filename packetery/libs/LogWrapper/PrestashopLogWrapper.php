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

namespace Packetery\LogWrapper;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Exception;

class PrestashopLogWrapper
{
    public const LEVEL_INFO = 1;
    public const LEVEL_ERROR = 3;

    /**
     * Add a log entry with default parameters
     *
     * @param string $message The log message
     * @param int $severity Log level (1=info, 2=warning, 3=error, 4=debug)
     * @param int|null $errorCode Error code (optional)
     * @param string|null $objectType Object type (optional)
     * @param int|null $objectId Object ID (optional)
     * @param bool $allowDuplicate Allow duplicate entries
     */
    public static function addLog(
        string $message,
        int $severity = self::LEVEL_INFO,
        int $errorCode = null,
        string $objectType = null,
        int $objectId = null,
        bool $allowDuplicate = true,
    ): void {
        \PrestaShopLogger::addLog(
            $message,
            $severity,
            $errorCode,
            $objectType,
            $objectId,
            $allowDuplicate
        );
    }

    /**
     * Log an error with exception details
     */
    public static function logException(string $message, \Exception $exception): void
    {
        $fullMessage =
            "{$message} Error: {$exception->getMessage()} in {$exception->getFile()}:{$exception->getLine()}";

        self::addLog(
            $fullMessage,
            self::LEVEL_ERROR
        );
    }
}
