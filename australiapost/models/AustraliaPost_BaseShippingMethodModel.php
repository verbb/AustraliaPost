<?php
namespace Craft;

class AustraliaPost_BaseShippingMethodModel extends BaseModel
{
    public function getType()
    {
        return Craft::t('Australia Post');
    }

    public function getId()
    {
        return null;
    }

    public function getIsEnabled()
    {
        return true;
    }

    public function getCpEditUrl()
    {
        return '#';
    }
}

