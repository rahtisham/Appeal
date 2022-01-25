<?php

namespace App\Http\Controllers;

use App\MWSDeveloperAccount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use \ClouSale\AmazonSellingPartnerAPI as AmazonSellingPartnerAPI;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getConfig(){

        $options = [
            'refresh_token' => 'Atzr|IwEBIMxNdMp-SVKIR6XzbunQLrZk64-Pq04uqTIEjGOftBSouwcw2hqvcpKLvTJjkzQ82VaZq8LgM9YZPKxJPbbasFPT3v00XgWghKMcWcxBfh0iM0QcMaAMTa5Gi76WVKYuJI7iX61A2eIrX-IruHMajS1zhLW8C_5n2tyT1u8zlh1zzUrERYOm9JgGD7YuK65bfAsGi5g07HoNcMhaF2AqUfuMYCKFh6wnIIRmAcfaEZXrxRAGW61m0FZNH7d8eFsSR65zcQ3QLautFsBWOmxb8t3Ln8aycmAge-OtFNLoy3-u0d6X9tRcP56P-FE8u6YkHmE',
            'client_id' => 'amzn1.application-oa2-client.53b10ed392774260b8757f867240a3bf',
            'client_secret' => 'e89af1d1e3d897c84793d6cd20b78bfca23c9b49a3fbf72ca6892c64a711ec66',
            'region' => AmazonSellingPartnerAPI\SellingPartnerRegion::$NORTH_AMERICA,
            'access_key' => 'AKIAWVVNNCPY557SJOGM',
            'secret_key' => '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',
            'endpoint' => AmazonSellingPartnerAPI\SellingPartnerEndpoint::$NORTH_AMERICA,
            'role_arn' => 'arn:aws:iam::458851423217:role/SellingPartnerAPI'
        ];

        $accessToken = \ClouSale\AmazonSellingPartnerAPI\SellingPartnerOAuth::getAccessTokenFromRefreshToken(
            $options['refresh_token'],
            $options['client_id'],
            $options['client_secret']
        );

        $assumedRole = \ClouSale\AmazonSellingPartnerAPI\AssumeRole::assume(
            $options['region'],
            $options['access_key'],
            $options['secret_key'],
            $options['role_arn'],
        );
        $config = \ClouSale\AmazonSellingPartnerAPI\Configuration::getDefaultConfiguration();
        $config->setHost($options['endpoint']);
        $config->setAccessToken($accessToken);
        $config->setAccessKey($assumedRole->getAccessKeyId());
        $config->setSecretKey($assumedRole->getSecretAccessKey());
        $config->setRegion($options['region']);
        $config->setSecurityToken($assumedRole->getSessionToken());

        return $config;
    }
}
