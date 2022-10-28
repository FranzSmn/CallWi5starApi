<?php
$ApiKey = "SLHZQB1B4XPRW1SN2B36X81NSRHX21N9";
$ApiSecret = "X9ZTM76VR9M9PG8253MNQT5HQNWQ3WHW";
$API = new RESTfulAPI("https://h11.wi5stars.com", $ApiKey, $ApiSecret);
$Endpoint = 'userWrite';
$firstName = 'asdasda';
$lastName = 'Hellasdasdao';
$Data = '{"id":"0", "DomainID":"1366", "UserName": "' . $firstName . '", "Password":"' . $lastName . '", "ProductID":"2347"}';
$JSonRetVal = $API->APICall($Endpoint, $Data);
if (isset($RetVal["error"]) && $RetVal["error"] != "") {
    echo "Error: " . $RetVal["error"];
} else {
    print_r($JSonRetVal);
}

class RESTfulAPI
{
    function __construct($DomainOrIP, $Key, $Secret)
    {
        $this->BaseUri = $DomainOrIP . "/api/v2/";
        $this->ApiKey = $Key;
        $this->ApiSecret = $Secret;
        // Encription vector initialization
        $this->SecretIV = substr(hash("SHA256", $this->ApiKey, true), 0, 16);
    }
    function base64Url_Encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    // Encription for properties
    function APIEncryptData($Data)
    {
        $output = openssl_encrypt(
            $Data,
            "AES-256-CBC",
            md5($this->ApiSecret),
            OPENSSL_RAW_DATA,
            $this->SecretIV
        );
        return $this->base64Url_Encode($output);
    }
    function APICall($Endpoint, $Data)
    {
        try {
            $Options = array(
                'http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => 'data=' . $this->APIEncryptData($Data)
                )
            );
            $context = stream_context_create($Options);
            $RetVal = file_get_contents($this->BaseUri . $Endpoint
                . "/apikey=" . $this->ApiKey, false, $context);
        } catch (Exception $e) {
            $RetVal = '{"warning":"","error":"Generic error"}';
        }
        return $RetVal;
    }
}
