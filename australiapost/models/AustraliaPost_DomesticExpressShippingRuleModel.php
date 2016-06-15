<?php
namespace Craft;

use Commerce\Interfaces\ShippingRule;

class AustraliaPost_DomesticExpressShippingRuleModel extends AustraliaPost_BaseShippingRuleModel implements ShippingRule
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

        // Because we're doing domestic, don't return any options if its international
        if ($country != 'Australia') {
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
            'service_code' => 'AUS_PARCEL_EXPRESS'
        );

        $this->_shippingOptions = $this->_getDomesticParcelPostage($request);

        if (!isset($this->_shippingOptions['postage_result']['total_cost'])) {
            return false;
        }

        return true;
    }

    public function getBaseRate()
    {
        if (isset($this->_shippingOptions['postage_result']['total_cost'])) {
            // Every $100, add mandatory insurance of $1.50
            $hundreds = ceil($this->_shippingOptions['postage_result']['total_cost'] / 100);

            return $this->_shippingOptions['postage_result']['total_cost'] + (1.5 * $hundreds);
        } else {
            return null;
        }
    }

    public function getDescription()
    {
        if (isset($this->_shippingOptions['postage_result']['total_cost'])) {
            return 'Next Business Day within the Express Post network (includes insurance)';
        } else {
            return null;
        }
    }
}
