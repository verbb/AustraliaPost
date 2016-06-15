<?php
namespace Craft;

class AustraliaPost_BaseShippingRuleModel extends BaseModel
{
    protected $_shippingOptions;

    protected function _makeRequest($endpoint, $request = array())
    {
        $fullEndpoint = 'http://auspost.com.au/api/postage/'.$endpoint.'.json';

        $headers = array( 'AUTH-KEY: 4e428100-4c88-4222-9d08-17a4e1757eb9' );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $fullEndpoint . '?' . http_build_query($request));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);

        curl_close($curl);

        $services = json_decode($response, true);

        return $services;
    }

    protected function _getDomesticParcelPostage($request)
    {
        return $this->_makeRequest('parcel/domestic/calculate', $request);
    }

    protected function _getInternationalParcelPostage($request)
    {
        return $this->_makeRequest('parcel/international/calculate', $request);
    }

    protected function _getCountryCode($countryName)
    {
        // Cached for better performance
        $countriesRaw = file_get_contents(CRAFT_PLUGINS_PATH . 'australiapost/countries.json');
        $countries = json_decode($countriesRaw, true);

        foreach ($countries['countries']['country'] as $country) {
            if (strtoupper($countryName) == $country['name']) {
                return $country['code'];
            }
        }
    }

    public function getIsEnabled()
    {
        return true;
    }

    public function getOptions()
    {
        return array(
            'percentageRate' => 0,
            'perItemRate' => 0,
            'weightRate' => 0,
            'baseRate' => 0,
            'maxRate' => 0,
            'minRate' => 0
        );
    }

    public function getPercentageRate()
    {
        return 0;
    }

    public function getPerItemRate()
    {
        return 0;
    }

    public function getWeightRate()
    {
        return 0;
    }

    public function getMaxRate()
    {
        return 0;
    }

    public function getMinRate()
    {
        return 0;
    }
}
