<?php
namespace Craft;

use Commerce\Interfaces\ShippingMethod;

class AustraliaPost_DomesticRegularShippingMethodModel extends AustraliaPost_BaseShippingMethodModel implements ShippingMethod
{
    public function getName()
    {
        return Craft::t('Australia Post Domestic Regular');
    }

    public function getHandle()
    {
        return 'australiaPostDomesticRegular';
    }

    public function getRules()
    {
        return array(
            new AustraliaPost_DomesticRegularShippingRuleModel(),
        );
    }
}
