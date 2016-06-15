<?php
namespace Craft;

use Commerce\Interfaces\ShippingMethod;

class AustraliaPost_InternationalExpressShippingMethodModel extends AustraliaPost_BaseShippingMethodModel implements ShippingMethod
{
    public function getName()
    {
        return Craft::t('Australia Post International Express');
    }

    public function getHandle()
    {
        return 'australiaPostInternationalExpress';
    }

    public function getRules()
    {
        return array(
            new AustraliaPost_InternationalExpressShippingRuleModel(),
        );
    }
}
