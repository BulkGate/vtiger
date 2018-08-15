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
            'af' =>"Afghánistán",
            'ax' =>"Ålandy",
            'al' =>"Albánie",
            'dz' =>"Alžírsko",
            'as' =>"Americká Samoa",
            'vi' =>"Americké Panenské ostrovy",
            'ad' =>"Andorra",
            'ao' =>"Angola",
            'ai' =>"Anguilla",
            'aq' =>"Antarktida",
            'ag' =>"Antigua a Barbuda",
            'ar' =>"Argentina",
            'am' =>"Arménie",
            'aw' =>"Aruba",
            'ac' =>"Ascension",
            'au' =>"Austrálie",
            'az' =>"Ázerbájdžán",
            'bs' =>"Bahamy",
            'bh' =>"Bahrajn",
            'bd' =>"Bangladéš",
            'bb' =>"Barbados",
            'be' =>"Belgie",
            'bz' =>"Belize",
            'by' =>"Bělorusko",
            'bj' =>"Benin",
            'bm' =>"Bermudy",
            'bt' =>"Bhútán",
            'bo' =>"Bolívie",
            'ba' =>"Bosna a Hercegovina",
            'bw' =>"Botswana",
            'bv' =>"Bouvetův ostrov",
            'br' => "Brazílie",
            'io' =>"Britské indickooceánské území",
            'vg' =>"Britské Panenské ostrovy",
            'bn' =>"Brunej",
            'bg' =>"Bulharsko",
            'bf' =>"Burkina Faso",
            'bi' =>"Burundi",
            'td' =>"Čad",
            'me' =>"Černá Hora",
            'cz' =>"Česká republika",
            'cl' =>"Chile",
            'hr' =>"Chorvatsko",
            'cn' =>"Čína",
            'ck' =>"Cookovy ostrovy",
            'an' =>"Curaçao",
            'cw' =>"Curaçao",
            'dk' =>"Dánsko",
            'dm' =>"Dominika",
            'do' =>"Dominikánská republika",
            'dj' =>"Džibutsko",
            'eg' =>"Egypt",
            'ec' =>"Ekvádor",
            'er' =>"Eritrea",
            'ee' =>"Estonsko",
            'et' =>"Etiopie",
            'fo' =>"Faerské ostrovy",
            'fk' =>"Falklandské ostrovy",
            'fj' =>"Fidži",
            'ph' =>"Filipíny",
            'fi' =>"Finsko",
            'fr' =>"Francie",
            'gf' =>"Francouzská Guyana",
            'tf' =>"Francouzská jižní území",
            'pf' =>"Francouzská Polynésie",
            'ga' =>"Gabon",
            'gm' =>"Gambie",
            'gh' =>"Ghana",
            'gi' =>"Gibraltar",
            'gd' =>"Grenada",
            'gl' =>"Grónsko",
            'ge' =>"Gruzie",
            'gp' =>"Guadeloupe",
            'gu' =>"Guam",
            'gt' =>"Guatemala",
            'gg' =>"Guernsey",
            'gn' =>"Guinea",
            'gw' =>"Guinea-Bissau",
            'gy' =>"Guyana",
            'ht' =>"Haiti",
            'hm' =>"Heardův ostrov a McDonaldovy ostrovy",
            'hn' =>"Honduras",
            'hk' =>"Hongkong – ZAO Číny",
            'in' =>"Indie",
            'id' =>"Indonésie",
            'iq' =>"Irák",
            'ir' =>"Írán",
            'ie' =>"Irsko",
            'is' =>"Island",
            'it' =>"Itálie",
            'il' =>"Izrael",
            'jm' =>"Jamajka",
            'jp' =>"Japonsko",
            'ye' =>"Jemen",
            'je' =>"Jersey",
            'za' =>"Jihoafrická republika",
            'gs' =>"Jižní Georgie a Jižní Sandwichovy ostrovy",
            'kr' =>"Jižní Korea",
            'ss' =>"Jižní Súdán",
            'jo' =>"Jordánsko",
            'ky' =>"Kajmanské ostrovy",
            'kh' =>"Kambodža",
            'cm' =>"Kamerun",
            'ca' =>"Kanada",
            'ic' =>"Kanárské ostrovy",
            'cv' =>"Kapverdy",
            'bq' =>"Karibské Nizozemsko",
            'qa' =>"Katar",
            'kz' =>"Kazachstán",
            'ke' =>"Keňa",
            'ki' =>"Kiribati",
            'cc' =>"Kokosové ostrovy",
            'co' =>"Kolumbie",
            'km' =>"Komory",
            'cg' =>"Kongo – Brazzaville",
            'cd' =>"Kongo – Kinshasa",
            'xk' =>"Kosovo",
            'cr' =>"Kostarika",
            'cu' =>"Kuba",
            'kw' =>"Kuvajt",
            'cy' =>"Kypr",
            'kg' =>"Kyrgyzstán",
            'la' =>"Laos",
            'ls' =>"Lesotho",
            'lb' =>"Libanon",
            'lr' =>"Libérie",
            'ly' =>"Libye",
            'li' =>"Lichtenštejnsko",
            'lt' =>"Litva",
            'lv' =>"Lotyšsko",
            'lu' =>"Lucembursko",
            'mo' =>"Macao – ZAO Číny",
            'mg' =>"Madagaskar",
            'hu' =>"Maďarsko",
            'mk' =>"Makedonie",
            'my' =>"Malajsie",
            'mw' =>"Malawi",
            'mv' =>"Maledivy",
            'ml' =>"Mali",
            'mt' =>"Malta",
            'ma' =>"Maroko",
            'mh' =>"Marshallovy ostrovy",
            'mq' =>"Martinik",
            'mu' =>"Mauricius",
            'mr' =>"Mauritánie",
            'yt' =>"Mayotte",
            'um' =>"Menší odlehlé ostrovy USA",
            'mx' =>"Mexiko",
            'fm' =>"Mikronésie",
            'md' =>"Moldavsko",
            'mc' =>"Monako",
            'mn' =>"Mongolsko",
            'ms' =>"Montserrat",
            'mz' =>"Mosambik",
            'mm' =>"Myanmar (Barma)",
            'na' =>"Namibie",
            'nr' =>"Nauru",
            'de' =>"Německo",
            'np' =>"Nepál",
            'ne' =>"Niger",
            'ng' =>"Nigérie",
            'ni' =>"Nikaragua",
            'nu' =>"Niue",
            'nl' =>"Nizozemsko",
            'nf' =>"Norfolk",
            'no' =>"Norsko",
            'nc' =>"Nová Kaledonie",
            'nz' =>"Nový Zéland",
            'om' =>"Omán",
            'im' =>"Ostrov Man",
            'pk' =>"Pákistán",
            'pw' =>"Palau",
            'ps' =>"Palestinská území",
            'pa' =>"Panama",
            'pg' =>"Papua-Nová Guinea",
            'py' =>"Paraguay",
            'pe' =>"Peru",
            'pn' =>"Pitcairnovy ostrovy",
            'ci' =>"Pobřeží slonoviny",
            'pl' =>"Polsko",
            'pr' =>"Portoriko",
            'pt' =>"Portugalsko",
            'at' =>"Rakousko",
            'gr' =>"Řecko",
            're' =>"Réunion",
            'gq' =>"Rovníková Guinea",
            'ro' =>"Rumunsko",
            'ru' =>"Rusko",
            'rw' =>"Rwanda",
            'pm' =>"Saint-Pierre a Miquelon",
            'sb' =>"Šalamounovy ostrovy",
            'sv' =>"Salvador",
            'ws' =>"Samoa",
            'sm' =>"San Marino",
            'sa' =>"Saúdská Arábie",
            'sn' =>"Senegal",
            'kp' =>"Severní Korea",
            'mp' =>"Severní Mariany",
            'sc' =>"Seychely",
            'sl' =>"Sierra Leone",
            'sg' =>"Singapur",
            'sk' =>"Slovensko",
            'si' =>"Slovinsko",
            'so' =>"Somálsko",
            'es' =>"Španělsko",
            'sj' =>"Špicberky a Jan Mayen",
            'ae' =>"Spojené arabské emiráty",
            'us' =>"Spojené státy",
            'rs' =>"Srbsko",
            'lk' =>"Srí Lanka",
            'cf' =>"Středoafrická republika",
            'sd' =>"Súdán",
            'sr' =>"Surinam",
            'sh' =>"Svatá Helena",
            'lc' =>"Svatá Lucie",
            'bl' =>"Svatý Bartoloměj",
            'kn' =>"Svatý Kryštof a Nevis",
            'mf' =>"Svatý Martin (Francie)",
            'st' =>"Svatý Tomáš a Princův ostrov",
            'vc' =>"Svatý Vincenc a Grenadiny",
            'sz' =>"Svazijsko",
            'se' =>"Švédsko",
            'ch' =>"Švýcarsko",
            'sy' =>"Sýrie",
            'tj' =>"Tádžikistán",
            'tz' =>"Tanzanie",
            'tw' =>"Tchaj-wan",
            'th' =>"Thajsko",
            'tg' =>"Togo",
            'tk' =>"Tokelau",
            'to' =>"Tonga",
            'tt' =>"Trinidad a Tobago",
            'ta' =>"Tristan da Cunha",
            'tn' =>"Tunisko",
            'tr' =>"Turecko",
            'tm' =>"Turkmenistán",
            'tc' =>"Turks a Caicos",
            'tv' =>"Tuvalu",
            'ug' =>"Uganda",
            'ua' =>"Ukrajina",
            'uy' =>"Uruguay",
            'uz' =>"Uzbekistán",
            'cx' =>"Vánoční ostrov",
            'vu' =>"Vanuatu",
            'va' =>"Vatikán",
            'gb' =>"Velká Británie",
            've' =>"Venezuela",
            'vn' =>"Vietnam",
            'tl' =>"Východní Timor",
            'wf' =>"Wallis a Futuna",
            'zm' =>"Zambie",
            'eh' =>"Západní Sahara",
            'zw' =>"Zimbabwe",
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
            "country" => $params["country"],
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