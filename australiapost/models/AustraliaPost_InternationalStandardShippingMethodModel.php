<?php
namespace Craft;

use Commerce\Interfaces\ShippingMethod;

class AustraliaPost_InternationalStandardShippingMethodModel extends AustraliaPost_BaseShippingMethodModel implements ShippingMethod
{
    public function getName()
    {
        return Craft::t('Australia Post International Standard');
    }

    public function getHandle()
    {
        return 'australiaPostInternationalStandard';
    }

    public function getRules()
    {
        return array(
            new AustraliaPost_InternationalStandardShippingRuleModel(),
        );
    }
}
