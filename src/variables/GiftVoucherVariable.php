<?php
namespace verbb\giftvoucher\variables;

use verbb\giftvoucher\GiftVoucher;
use verbb\giftvoucher\elements\db\CodeQuery;
use verbb\giftvoucher\elements\db\VoucherQuery;
use verbb\giftvoucher\elements\Code;
use verbb\giftvoucher\elements\Voucher;

use Craft;

use craft\commerce\Plugin as Commerce;
use craft\commerce\elements\Order;
use craft\commerce\models\LineItem;

class GiftVoucherVariable
{
    // Public Methods
    // =========================================================================

    public function getPlugin(): GiftVoucher
    {
        return GiftVoucher::$plugin;
    }

    public function getVoucherTypes(): array
    {
        return GiftVoucher::$plugin->getVoucherTypes()->getAllVoucherTypes();
    }

    public function getEditableVoucherTypes(): array
    {
        return GiftVoucher::$plugin->getVoucherTypes()->getEditableVoucherTypes();
    }

    public function vouchers(): VoucherQuery
    {
        return Voucher::find();
    }

    public function codes(): CodeQuery
    {
        return Code::find();
    }

    public function getVoucherCodes()
    {
        return Craft::$app->getSession()->get('giftVoucher.giftVoucherCodes');
    }

    public function isVoucher(LineItem $lineItem)
    {
        return (bool)(get_class($lineItem->purchasable) === Voucher::class);
    }

    public function getPdfUrl(LineItem $lineItem)
    {
        if ($this->isVoucher($lineItem)) {
            $order = $lineItem->order;

            return GiftVoucher::$plugin->getPdf()->getPdfUrl($order, $lineItem);
        }

        return null;
    }

    public function getOrderPdfUrl(Order $order)
    {
        return GiftVoucher::$plugin->getPdf()->getPdfUrl($order);
    }
}
