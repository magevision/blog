<?php
/**
 * MageVision Blog54
 *
 * @category     MageVision
 * @package      MageVision_Blog54
 * @author       MageVision Team
 * @copyright    Copyright (c) 2020 MageVision (https://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\Blog54\Model;

use Magento\Sales\Api\Data\ShipmentTrackInterfaceFactory;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Tracking
{
    /**
     * @var ShipmentRepositoryInterface
     */
    private $shipmentRepository;

    /**
     * @var ShipmentTrackInterfaceFactory
     */
    private $trackFactory;

    /**
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param ShipmentTrackInterfaceFactory $trackFactory
     */
    public function __construct(
        ShipmentRepositoryInterface $shipmentRepository,
        ShipmentTrackInterfaceFactory $trackFactory
    ) {
        $this->shipmentRepository = $shipmentRepository;
        $this->trackFactory = $trackFactory;
    }

    /**
     * @param int $shipmentId
     */
    public function addCustomTrack($shipmentId)
    {
        $number = 12345;
        $carrier = 'custom';
        $title = 'Custom Title';

        try {
            $shipment = $this->shipmentRepository->get($shipmentId);
            $track = $this->trackFactory->create()->setNumber(
                $number
            )->setCarrierCode(
                $carrier
            )->setTitle(
                $title
            );
            $shipment->addTrack($track);
            $this->shipmentRepository->save($shipment);

        } catch (NoSuchEntityException $e) {
            //Shipment does not exist
        }
    }
}