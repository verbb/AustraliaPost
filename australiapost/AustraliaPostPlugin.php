<?php
namespace Craft;

class AustraliaPostPlugin extends BasePlugin
{
    /* --------------------------------------------------------------
    * PLUGIN INFO
    * ------------------------------------------------------------ */

    public function getName()
    {
        return 'Australia Post';
    }

    public function getVersion()
    {
        return '0.0.1';
    }

    public function getDeveloper()
    {
        return 'S. Group';
    }

    public function getDeveloperUrl()
    {
        return 'http://sgroup.com.au';
    }



    // Private Methods
    // =========================================================================

    public function commerce_registerShippingMethods()
    {
        return array(
            new AustraliaPost_DomesticRegularShippingMethodModel(),
            new AustraliaPost_DomesticExpressShippingMethodModel(),
            new AustraliaPost_InternationalCourierShippingMethodModel(),
            new AustraliaPost_InternationalEconomyAirShippingMethodModel(),
            new AustraliaPost_InternationalExpressShippingMethodModel(),
            new AustraliaPost_InternationalStandardShippingMethodModel(),
        );

    }

}