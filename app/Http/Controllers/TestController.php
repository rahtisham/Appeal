<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Goutte;
use Goutte\Client;
use Spatie\ArrayToXml\ArrayToXml;

class TestController extends Controller
{
    public function index() {
        $data['tasks'] = [
                [
                        'name' => 'Design New Dashboard',
                        'progress' => '87',
                        'color' => 'danger'
                ],
                [
                        'name' => 'Create Home Page',
                        'progress' => '76',
                        'color' => 'warning'
                ],
                [
                        'name' => 'Some Other Task',
                        'progress' => '32',
                        'color' => 'success'
                ],
                [
                        'name' => 'Start Building Website',
                        'progress' => '56',
                        'color' => 'info'
                ],
                [
                        'name' => 'Develop an Awesome Algorithm',
                        'progress' => '10',
                        'color' => 'success'
                ]
        ];
        return view('test')->with($data);
    }

    public function scraping(){

        $url = 'https://www.walmart.com/ip/VIZIO-50-Class-4K-UHD-LED-Quantum-Smart-TV-HDR-M6x-Series-M506x-H9/910109519';

        $client = new Client();
        $crawler = $client->request('GET', $url);
        
        //$crawler = Goutte::request('GET', $url);
        //page title is in h1 tag
        //get title of the page
        echo "<pre>"; print_r($crawler->filter('h1')->first()->text());

        //get content of the page
        //echo $crawler->filter('.single-page-content')->text();

       /* $apiHeaders = array(
            'Accept: application/html',
            'feedId: 02C62B8613694C9ABDF78CBBC8386A39@AQMBAAA',
            'includeDetails: true',
            'offset: 0',
            'limit: 50',
            'WM_CONSUMER.CHANNEL.TYPE: SWAGGER_CHANNEL_TYPE',
            'WM_CONSUMER.ID: 251bd...', // commented out for security
            'WM_SEC.TIMESTAMP: '.time(),
            'WM_SEC.AUTH_SIGNATURE: MIICdgIBA...', // commented out for security
            'WM_SVC.NAME: Walmart Marketplace',
            'WM_QOS.CORRELATION_ID: 123456abcdef'
        );

        $apiURL = 'https://www.walmart.com/ip/VIZIO-50-Class-4K-UHD-LED-Quantum-Smart-TV-HDR-M6x-Series-M506x-H9/910109519';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $apiHeaders);
        curl_setopt($ch, CURLOPT_URL,$apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;exit;

        $dom = HtmlDomParser::str_get_html($response);

        echo $dom;

        exit('here');*/

		//require 'simple_html_dom.php';

		/*$html = file_get_contents('https://www.walmart.com/ip/VIZIO-50-Class-4K-UHD-LED-Quantum-Smart-TV-HDR-M6x-Series-M506x-H9/910109519');
        echo $html;exit;
		$title = $html->find('title', 0);
		$image = $html->find('img', 0);

		echo $title->plaintext."<br>\n";
		echo $image->src;*/
    }
}
