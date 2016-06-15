<?php
namespace Craft;

use Commerce\Interfaces\ShippingRule;

class AustraliaPost_InternationalExpressShippingRuleModel extends AustraliaPost_BaseShippingRuleModel implements ShippingRule
{
    public function getHandle()
    {
        return 'australiaPostRuleId' . $this->id;
    }

    public function matchOrder(Commerce_OrderModel $order)
    {
        if (!$order->shippingAddress) {
            return false;
        }

        $postcode = $order->shippingAddress->zipCode;
        $country = $order->shippingAddress->country;
        $totalWeight = $order->totalWeight;

        // Get Country Code from AusPost
        $countryCode = $this->_getCountryCode($country);

        // Because we're doing international, don't return any options if its domestic
        if ($country == 'Australia') {
            return false;
        }

        // This isn't correct, and we should be using totals, but the arugment could be made
        // that packing could be done intuitively to maximise space. We don't want shipping options
        // to be unavailable if things can be packed a little better
        $maxWidth = 0;
        $maxLength = 0;
        $maxHeight = 0;

        foreach ($order->lineItems as $key => $lineItem) {
            if ($maxWidth < $lineItem->width) {
                $maxWidth = $lineItem->width;
            }

            if ($maxLength < $lineItem->length) {
                $maxLength = $lineItem->length;
            }

            if ($maxHeight < $lineItem->height) {
                $maxHeight = $lineItem->height;
            }
        }

        $request = array(
            'from_postcode' => '7000',
            'country_code' => $countryCode,
            'to_postcode' => $postcode,
            'length' => $maxLength / 10, // mm to cm
            'width' => $maxWidth / 10, // mm to cm
            'height' => $maxHeight / 10, // mm to cm
            'weight' => $totalWeight / 1000, // g to kg
            'service_code' => 'INT_PARCEL_EXP_OWN_PACKAGING'
        );

        $this->_shippingOptions = $this->_getInternationalParcelPostage($request);

        if (!isset($this->_shippingOptions['postage_result']['total_cost'])) {
            return false;
        }

        return true;
    }

    public function getBaseRate()
    {
        if (isset($this->_shippingOptions['postage_result']['total_cost'])) {
            // For the first $100, add mandatory insurance of $9.60, and $2.50 for each additional
            $hundreds = ceil($this->_shippingOptions['postage_result']['total_cost'] / 100);
            $value = ($hundreds == 1) ? 9.6 : 2.5;

            return $this->_shippingOptions['postage_result']['total_cost'] + $value;
        } else {
            return null;
        }
    }

    public function getDescription()
    {
        if (isset($this->_shippingOptions['postage_result']['service'])) {
            return $this->_shippingOptions['postage_result']['service'] . ' (includes insurance)';
        } else {
            return null;
        }
    }

}
