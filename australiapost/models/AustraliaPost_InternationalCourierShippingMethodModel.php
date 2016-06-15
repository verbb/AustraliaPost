<?php
namespace Craft;

use Commerce\Interfaces\ShippingMethod;

class AustraliaPost_InternationalCourierShippingMethodModel extends AustraliaPost_BaseShippingMethodModel implements ShippingMethod
{
    public function getName()
    {
        return Craft::t('Australia Post International Courier');
    }

    public function getHandle()
    {
        return 'australiaPostInternationalCourier';
    }

    public function getRules()
    {
        return array(
            new AustraliaPost_InternationalCourierShippingRuleModel(),
        );
    }
}
