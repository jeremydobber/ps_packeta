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

namespace Packetery\PacketTracking;

if (!defined('_PS_VERSION_')) {
    exit;
}

class PacketStatusFactory
{
    /** @var \Packetery */
    private $module;

    /**
     * @param \Packetery $module
     */
    public function __construct(\Packetery $module)
    {
        $this->module = $module;
    }

    /**
     * Gets packet statuses and their translated explanations.
     *
     * @return PacketStatus[]
     */
    public function getPacketStatuses()
    {
        return [
            PacketStatus::RECEIVED_DATA => new PacketStatus(
                PacketStatus::RECEIVED_DATA,
                'received data',
                $this->module->l('Awaiting consignment', 'packetstatusfactory'),
                false
            ),
            PacketStatus::ARRIVED => new PacketStatus(
                PacketStatus::ARRIVED,
                'arrived',
                $this->module->l('Accepted at depot', 'packetstatusfactory'),
                false
            ),
            PacketStatus::PREPARED_FOR_DEPARTURE => new PacketStatus(
                PacketStatus::PREPARED_FOR_DEPARTURE,
                'prepared for departure',
                $this->module->l('On the way', 'packetstatusfactory'),
                false
            ),
            PacketStatus::DEPARTED => new PacketStatus(
                PacketStatus::DEPARTED,
                'departed',
                $this->module->l('Departed from depot', 'packetstatusfactory'),
                false
            ),
            PacketStatus::READY_FOR_PICKUP => new PacketStatus(
                PacketStatus::READY_FOR_PICKUP,
                'ready for pickup',
                $this->module->l('Ready for pick-up', 'packetstatusfactory'),
                false
            ),
            PacketStatus::HANDED_TO_CARRIER => new PacketStatus(
                PacketStatus::HANDED_TO_CARRIER,
                'handed to carrier',
                $this->module->l('Handed over to carrier company', 'packetstatusfactory'),
                false
            ),
            PacketStatus::DELIVERED => new PacketStatus(
                PacketStatus::DELIVERED,
                'delivered',
                $this->module->l('Delivered', 'packetstatusfactory'),
                true
            ),
            PacketStatus::POSTED_BACK => new PacketStatus(
                PacketStatus::POSTED_BACK,
                'posted back',
                $this->module->l('Returning (on the way back)', 'packetstatusfactory'),
                false
            ),
            PacketStatus::RETURNED => new PacketStatus(
                PacketStatus::RETURNED,
                'returned',
                $this->module->l('Returned to sender', 'packetstatusfactory'),
                true
            ),
            PacketStatus::CANCELLED => new PacketStatus(
                PacketStatus::CANCELLED,
                'cancelled',
                $this->module->l('Cancelled', 'packetstatusfactory'),
                true
            ),
            PacketStatus::COLLECTED => new PacketStatus(
                PacketStatus::COLLECTED,
                'collected',
                $this->module->l('Parcel has been collected', 'packetstatusfactory'),
                false
            ),
            PacketStatus::CUSTOMS => new PacketStatus(
                PacketStatus::CUSTOMS,
                'customs',
                $this->module->l('Customs declaration process', 'packetstatusfactory'),
                false
            ),
            PacketStatus::REVERSE_PACKET_ARRIVED => new PacketStatus(
                PacketStatus::REVERSE_PACKET_ARRIVED,
                'reverse packet arrived',
                $this->module->l('Reverse parcel has been accepted at our pick up point', 'packetstatusfactory'),
                false
            ),
            PacketStatus::DELIVERY_ATTEMPT => new PacketStatus(
                PacketStatus::DELIVERY_ATTEMPT,
                'delivery attempt',
                $this->module->l('Unsuccessful delivery attempt of parcel', 'packetstatusfactory'),
                false
            ),
            PacketStatus::REJECTED_BY_RECIPIENT => new PacketStatus(
                PacketStatus::REJECTED_BY_RECIPIENT,
                'rejected by recipient',
                $this->module->l('Rejected by recipient response', 'packetstatusfactory'),
                false
            ),
            PacketStatus::UNKNOWN => new PacketStatus(
                PacketStatus::UNKNOWN,
                'unknown',
                $this->module->l('Unknown parcel status', 'packetstatusfactory'),
                true
            ),
        ];
    }
}
