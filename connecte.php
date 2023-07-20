<?php
require 'vendor/autoload.php';
require 'config.php';
use GuzzleHttp\client;
use GuzzleHttp\Exception\ClientException;
$client = new Client([
    'timeout' => 2.0,
    'verify' => __DIR__ . './cacert.pem'
]);
try{
    $Response = $client->request('GET','https://accounts.google.com/.well-known/openid-configuration');
    $token = (json_decode((string)($Response->getBody())))->token_endpoint;
    $Response = $client->request('POST' . $token,[
       'form_params' =>
       [
           'code'=>$_GET['code'],
           'client_id' =>GOOGLE_ID,
           'client_secret' => GOOGLE_SECRET,
           'redirect_uri' =>'http://localhost:8000/connecte.php',
           'gerant_type' =>'autorisation_code'
       ]
    ]);
} catch(ClientException $exception){
 dd($exception->getMessage());
}

 dd((String)$Response->getBody());

?>