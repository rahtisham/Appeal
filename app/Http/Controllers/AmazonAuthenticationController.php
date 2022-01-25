<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AmazonAuthenticationController extends Controller
{
    public function AmzAuthenticated(){

                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.amazon.com/auth/o2/token',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=Atzr%7CIwEBIMPJUZ-09UEyt4pO0LQ6utGkksDZPp__c_bege9_vP7z88haaLPeQd2ErLqXWbOlsGKejSDTjud8qApAzlyvf1m_g3Bc1O0LDzIUQqIjFQ_d93pD2IAjHlDM16_956uXSjgZcMbICjuZW3zFD9m9uXi_EAa60BDATpQA-8sMLGUL674xlB_BA377hsLo_aOr9TlftAYIIN4rTt5hZHI6WGsURFLRSSnrupoJAlgxFVxvuiaXzVH0SsE1P4o58j4MQdwIQuBm0sxVmfNHAloA64vdfANWEpqcXBGaRe9zJIEil7ddBEC1klw2cGsyf865o7s&client_id=amzn1.application-oa2-client.551894488b6e48a79da7d256c01fcd51&client_secret=66c97a28ae3c3ae75084f3b30b03f178419aacc1b6849b8495881368c2c48204',
                  CURLOPT_HTTPHEADER => array(
                    'X-Amz-Content-Sha256: 7f93c7d005e5f84d19fcd00edc40a46be6f9bf007c227239fd4cea5656aa1f27',
                    'X-Amz-Date: 20211230T121007Z',
                    'Authorization: AWS4-HMAC-SHA256 Credential=AKIAUFXBVIXZTXOFFXNN/20211230/us-east-1/sts/aws4_request, SignedHeaders=host;x-amz-content-sha256;x-amz-date, Signature=104348760d9288aaa757a0242a3973298712ba43e6c444758313a8127e1dc27c',
                    'Content-Type: application/x-www-form-urlencoded'
                  ),
                ));

                $response = curl_exec($curl);

                $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                curl_close($curl);
                echo $response;
    }
}
