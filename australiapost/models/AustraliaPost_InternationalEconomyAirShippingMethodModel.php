<?php
namespace Craft;

use Commerce\Interfaces\ShippingMethod;

class AustraliaPost_InternationalEconomyAirShippingMethodModel extends AustraliaPost_BaseShippingMethodModel implements ShippingMethod
{
    public function getName()
    {
        return Craft::t('Australia Post International Economy Air');
    }

    public function getHandle()
    {
        return 'australiaPostInternationalEconomyAir';
    }

    public function getRules()
    {
        return array(
            new AustraliaPost_InternationalEconomyAirShippingRuleModel(),
        );
    }
}
