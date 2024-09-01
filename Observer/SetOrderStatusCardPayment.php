<?php

namespace Adyen\Payment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class SetOrderStatusCardPayment implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();
        $payment = $order->getPayment();
        $paymentMethod = $payment->getMethod();

        if ($paymentMethod === 'adyen_cc' && $order->getState() === Order::STATE_NEW) {
            $order->setStatus('CREDIT_CARD_HOLD');
            $order->save();
        }
    }
}
