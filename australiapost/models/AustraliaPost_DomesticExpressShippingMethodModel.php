<?php
namespace Craft;

use Commerce\Interfaces\ShippingMethod;

class AustraliaPost_DomesticExpressShippingMethodModel extends AustraliaPost_BaseShippingMethodModel implements ShippingMethod
{
    public function getName()
    {
        return Craft::t('Australia Post Domestic Express');
    }

    public function getHandle()
    {
        return 'australiaPostDomesticExpress';
    }

    public function getRules()
    {
        return array(
            new AustraliaPost_DomesticExpressShippingRuleModel(),
        );
    }
}
