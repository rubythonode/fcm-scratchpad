<?php

use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;
use paragraph1\phpFCM\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('gcm', function () {
    $apiKey = config('fcm.http.server_key');
    $client = new Client();
    $client->setApiKey($apiKey);
    $client->injectHttpClient(new \GuzzleHttp\Client());

    $note = new Notification('알림 제목', '알림 본문');
    $note->setIcon('notification_icon_resource_name')->setColor('#ffffff')->setBadge(1);

    $message = new Message();
    $message->addRecipient(new Device('eIrjxWASTb0:APA91bF8mv9AdXMAxQ0ALcvFJ4zvfzLxDs7LmGXrKB4btklQKuhcD94KTJV7tCghnxSQMAsShTjzjWHfWDC1aXe_JAQO0Ao4nuFEfpQI0QaUyX7Mh0aFm1RLVDhcP7nAArzaxF6jBFJx'));
    $message->setNotification($note)->setData(['foo' => 'bar']);

    $response = $client->send($message);

    var_dump('response object', $response);

    var_dump('json decoded content', json_decode($response->getBody()->getContents()));
});
