<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RulesController extends Controller
{
    public function index(){

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://marketplace.walmartapis.com/v3/getReport?type=shippingProgram&version=v1',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic Mjg5ZDZmYWItZmQ1Ny00YTgwLTkxYjQtZDU3NTAyZGE2OTk2OmZQOEd6TG5WSU1sSGg0T0RkeW9VdHZsVWgteDJpTE04R2hrQUoxUFI1QnJicFUwa1M0Z05TeTRISjNESU43S0lSRk5NbDNoOVRsMnp4OEI4N1NEcmFn',
                'WM_SVC.NAME: Walmart Marketplace',
                'WM_QOS.CORRELATION_ID: Test Seller',
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'WM_SEC.ACCESS_TOKEN: eyJraWQiOiJiN2JmYjM1OC1lODYzLTRjMzItYmUxZC00M2I4NTIyMzkyZjMiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..tLeEXk225aaKCgBJ.niHFDZpSHy5C9VzAvgM36kzD7M-DpPIoW-mPET9919XqedAKFJ42UwT5rQXVKCESjG7rgFU2ZVyzxfJcCYrDJOxTZ58KSp0RAqraitk3-AlMqWtsKXnvyXspLEtXxqG29_JBlLpClH9Zd-kE4xyqZczlWUDE7eex6qd9s1y159JzQBgWMF25uX-_lO5S4DSgSCNMAIbjuiR8dARiHQR2QUYwTFJYcbGX_3bxUWPlWI2qyw_qHjdLBVcjAGgwpgXsw6rhcWCfc_8zjjMKZBAlp-PBIfM9_dYus1KYV8OSc7oIMhR6522IVW5vEZe6wrOB6hsTSDj4GSV4f7vxFuS8r4cdZhNRi2cDBbqTzX6pJ4q8jhGxTITIVJ1Xn_exJw7FY3THk9VamQXQxg9Z9Fy8pMD72o8JOI5RiQ-EnschpH1uMg3IkLpdG2f5D1jPWO51VW8tFGpEagWhtFIuVrwbxN9nTQMpLf3Lf_G44jBOqXt5cppFYRn_xlbe4146H-OSuIk3t5PO4dlpNRcFuOEnFk06Q1URUarrNIFzs0oPsbjdt3tn_Yoe1gyi-Geb1swJg3hQ0bD_ePSKscRK5son1wFH2BA8CuPplVdzh0pnspm7TCkPg0ow5zuyK_jAd5IU5TjFeYKq72fhluB3KARlMbVmuvHXNSfJePpw27PZKEOHQsd3SdhgC_a1GJD5.Nb1y0Ln-_p3-Fg-NA69caA',
                'Cookie: TS01f4281b=0130aff2327618c0c04b05f1fa24241630b7dd01ee3a17348decf42da86192a27f49dcff167382b85712856c780ed769dea8573fd2'
              ),
            ));
            
            $response = curl_exec($curl);
            
            echo "<pre>";
            print_r($response); exit;
            
            curl_close($curl);
            echo $response;

    }

    public function deliverdProduct(){

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.walmartapis.com/v3/orders?status=Delivered',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic Mjg5ZDZmYWItZmQ1Ny00YTgwLTkxYjQtZDU3NTAyZGE2OTk2OmZQOEd6TG5WSU1sSGg0T0RkeW9VdHZsVWgteDJpTE04R2hrQUoxUFI1QnJicFUwa1M0Z05TeTRISjNESU43S0lSRk5NbDNoOVRsMnp4OEI4N1NEcmFn',
              'WM_SEC.ACCESS_TOKEN: eyJraWQiOiJiN2JmYjM1OC1lODYzLTRjMzItYmUxZC00M2I4NTIyMzkyZjMiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..y9fK0C13aqnbHyH7.HXKaLTrt6c_JpHx458YbIdGElOU9146Z2BmciFESX5azSMRLhYmu8Pr-rwH2UywaaWp684aeTO7cq-QK56ha6GJOBH-SrJ_GFBMK9MLrLzMjbnD8eRLqSjJeO-98zvv7kN1BJw7sMgEH8hOBFEazoYISPx5qkHcaW5q0EDyc2YdzfQTN6e7ZJ9ZscEEPxhO9srrOZNlprojA4qwHJ9z1T0NCPIJObRKiKHwiIdiYCFBdaLolHaGtnR_ebH3NicYbKCf7P8S0Y5K9euqW-FWX3GS3sLfKRcp2weHjQIAWfO8fiO9QU8EiQFUto8eWw2ntO8OWHrVWnQieVSp4VCmpmB4v2ei8UVbW0xnqlkLK8bZRGdPCbG_6PID_54JtHYClMls0cfn9Mi0pVwgTlqbPCKFbFT-ijqQ8pj6ushXX_ntp341zUCzK6wctCLBa_u5KxMUEcRnxvwD2TgBs_tusiyWXfdP4lXNU17-UH51UEHnmSeYDYxyBlXUCHKGPOxK1N5mYuKaZ2Rs7d52fpbndDx6U30y6AwQ1h05aJl5rUvY9HPfD_P7eh_Uf1Kt6XZIX005s3PO-KjdEIGOZOfw47H1E7sVnHP3IGA5jQXaX2iViOCxp-3UBqD5GyMde9GA1Lhe5p8h5PPgtV2GNSZaep9XYM2ufOG6-suOmCzlZ2jO374O1LlOYRnENFSPS.Aa4VmSCWmAf78Y9J75TLeQ',
              'WM_QOS.CORRELATION_ID: Test Seller',
              'WM_SVC.NAME: Walmart Marketplace',
              'Accept: application/json',
              'Content-Type: application/x-www-form-urlencoded',
              'Cookie: TS01f4281b=0130aff232ae1bb83a9c1825a564f48add5eb153dd555cf28e5d9510add00c0a3418778104d4519c305d0b3d3b5a93849dd4443805'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
          echo $response;

    }



    public function shipingProduct(){
      
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.walmartapis.com/v3/orders?status=Shipped',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Basic Mjg5ZDZmYWItZmQ1Ny00YTgwLTkxYjQtZDU3NTAyZGE2OTk2OmZQOEd6TG5WSU1sSGg0T0RkeW9VdHZsVWgteDJpTE04R2hrQUoxUFI1QnJicFUwa1M0Z05TeTRISjNESU43S0lSRk5NbDNoOVRsMnp4OEI4N1NEcmFn',
              'WM_SEC.ACCESS_TOKEN: eyJraWQiOiJiN2JmYjM1OC1lODYzLTRjMzItYmUxZC00M2I4NTIyMzkyZjMiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..aSSIbiEbNTdn6lr1.8iGz5YSo3qY4S2EqfLHfXldVQrHaRMxYUz1d_xS6zZwtYefLu4jzaG9pgZaTZYtyL9Nk-qhwX-lazPIZkMszP34Ibu_FN4mum_SQTCz0KYSxkoSCyOAq0pOKigQStgo28TmUWlpCsGVRYsjBmdXPrjlY828ewX9RhZHKpioxhskdgzDvp6po7hYhNPY1F1uGc2jE6kvkPniKQBJdToOIaUYXrRWIomrtjClrHkw24YCIcBOssLpd1_GfV6CL1tRTIewPRFI1E-1Qj-thZxbTXqREwUHFSkrHjSgAvROeecOdFtb4XnVBs0fD4rMLxQ4zx82Ovp01d2sH__fgsgBKoSgr-COnbhSSlhP-jE-fLxyJLEk3olzJPScsxB_8JeKK091HZNqv0zWxFiTzd6pDMt3AFEUAOdwFna9wc5P1JdD6dwoRj9jYYLHPiLfSYLsPZ8t25-tq_94jf1uL5Mp3ULtENrvtr1ul2v3IS_E4URfuCLV8Vna8kAY7Ee-J2dEzBeRbWMZ3m3MvxaftZjQafrifm3YhKJdXi0trdovrsdNrqcvI9PEt1Q5JOituQQ4Kw6LAsJPdIwV-B16Osiq7UJfoBVjaTEnKEUe16INGnsOFd4iUD1sAH1OhDVrPm47u_2KxfUi1NOAgKXYJZKTvXMAXetaDN4Fv5JPJnOAx5DZfUxBVbT7uAMjxESfV.sN2kk9yQSsPsCLDnaoPc9g',
              'WM_QOS.CORRELATION_ID: Test Seller',
              'WM_SVC.NAME: Walmart Marketplace',
              'Accept: application/json',
              'Content-Type: application/x-www-form-urlencoded',
              'Cookie: TS01f4281b=0130aff2326710a8e3015cff89f96f0d2cb286f06d1e267c4ee7276bc2852ce12f941b0674de6285e3ecc13e94cdaaaed47e45a979'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);
          echo $response;

    }
    public function template()
    {
        return view('template');
    }
}
