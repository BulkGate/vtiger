<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class SMSNotifier_BulkGate_Provider implements SMSNotifier_ISMSProvider_Model 
{  	
	private $username;
    private $password;
    private $parameters = array();

    const SERVICE_URI = 'https://portal.bulkgate.com/api/1.0/simple';

    private static $REQUIRED_PARAMETERS = array(
        array('name' => 'username', 'label' => 'Application ID', 'type' => 'text'),
        array('name' => 'password', 'label' => 'Application token', 'type' => 'text'),
        array('name' => 'sender_id', 'label' => 'Sender ID', 'type' => 'text'),
        array('name' => 'sender_id_value', 'label' => 'Sender value', 'type' => 'text'),
        array('name' => 'unicode', 'label' => 'Character Set', 'type' => 'picklist', 'picklistvalues' => array('1' => 'Unicode', '0' => '7bit')),
        array('name' => 'country', 'label' => 'Country', 'type' => 'picklist', 'picklistvalues' => array(
            '' => "-",
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
            'false' => "-")),
    );

    public function getName() 
	{
        return 'BulkGate';
    }

    public function setAuthParameters($username, $password) 
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function setParameter($key, $value) 
    {
        $this->parameters[$key] = $value;
    }

    public function getParameter($key, $defaultvalue = false) 
    {
        if (isset($this->parameters[$key])) 
        {
            return $this->parameters[$key];
        }
        return $defaultvalue;
    }

    public function getRequiredParams() 
    {
        return self::$REQUIRED_PARAMETERS;
    }

    public function getServiceURL($type = false) 
	{
        if ($type)
        {
            switch (strtoupper($type)) 
            {
                case self::SERVICE_SEND : return self::SERVICE_URI.'/promotional/';
                //case self::SERVICE_QUERY : return self::SERVICE_URI . '/status/message/';
            }
        }
        return false;
    }

    protected function prepareParameters() 
	{
        foreach (self::$REQUIRED_PARAMETERS as $requiredParam)
        {
            $paramName = $requiredParam['name'];
            $params[$paramName] = $this->getParameter($paramName);
        }
        $params['format'] = 'json';
        return $params;
    }

    public function send($message, $tonumbers)
    {
        if (!is_array($tonumbers))
        {
            $tonumbers = array($tonumbers);
        }

        $params = $this->prepareParameters();
        $params['text'] = $message;
        $params['number'] = implode(';', $tonumbers);

        $serviceURL = $this->getServiceURL(self::SERVICE_SEND);
        $httpClient = new Vtiger_Net_Client($serviceURL);
        $response = $httpClient->doPost(array(
            "application_id" => $params['username'],
            "application_token" => $params['password'],
            "unicode" => $params["unicode"],
            "number" => $params["number"],
            "text" => $params["text"],
            "sender_id" => $params["sender_id"],
            "sender_id_value" => $params["sender_id_value"],
            "country" => strtolower($params["country"]),
        ));

        $rows = json_decode($response, true);
        $numbers = explode(';', $params['number']);
        $results = array();

        if(isset($rows['error']))
        {
            foreach ($numbers as $number)
            {
                $results[] = array(
                    'to' => $number,
                    'error' => true,
                    'statusmessage' => $rows['error'],
                    'status' => self::MSG_STATUS_ERROR
                );
            }
        }
        else if(isset($rows['data']) && isset($rows['data']['response']))
        {
            foreach ($rows['data']['response'] as $value)
            {
                $value = (array) $value;

                $results[] = array(
                    'error' => $value['status'] === 'error',
                    'to' => $value['number'],
                    'id' => $value['sms_id'],
                    'statusmessage' => isset($value['error']) ? $value['error'] : $value['status'],
                    'status' => $this->checkstatus($value['status'])
                );
            }
        }

        return $results;
    }

    public function checkstatus($status) 
    {
        if ($status == 'sent')
        {
            $result = self::MSG_STATUS_DISPATCHED;
        } 
        elseif ($status == 'accepted')
        {
            $result = self::MSG_STATUS_DELIVERED;
        }
        elseif ($status == 'scheduled')
        {
            $result = self::MSG_STATUS_PROCESSING;
        }
        elseif($status == 'error')
        {
            $result = self::MSG_STATUS_ERROR;
        }
        return $result;
    }

    public function query($messageid)
    {
        /*$params = $this->prepareParameters();
        $params['messageid'] = $messageid;
        $serviceURL = $this->getServiceURL(self::SERVICE_QUERY);
        $httpClient = new Vtiger_Net_Client($serviceURL);
        $response = $httpClient->doGet($params);
        $rows = json_decode($response, true);
        $result = array();

        if(isset($rows['error']))
        {
            $result['error'] = true;
            $result['status'] = self::MSG_STATUS_ERROR;
            $result['needlookup'] = 1;
            $result['statusmessage'] = $rows['message'];
        }
        else if(isset($rows['data']) && isset($rows['data']['response']))
        {
            $result['error'] = false;
            $result['status'] = $this->checkstatus($rows['data']['0']['status']);
            $result['needlookup'] = 0;
            $result['statusmessage'] = $rows['message'];
        }
        return $result;*/
    }

    function getProviderEditFieldTemplateName() 
    {
        return 'BaseProviderEditFields.tpl';
    }
}