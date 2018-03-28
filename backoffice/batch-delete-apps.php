#!/usr/bin/env php
<?php

$siberianDomain = readline('Your siberian domain (example https://myappbuilder.com: ');

$login = "curl '#DOMAIN#/backoffice/account_login/post' \
    --silent \
    -c 'siberian-cookie.txt' \
    -H 'accept-encoding: gzip, deflate, br' \
    -H 'accept-language: en-GB,en-US;q=0.9,en;q=0.8' \
    -H 'x-requested-with: XMLHttpRequest' \
    -H 'pragma: no-cache' \
    -H 'user-agent: Insomnia/1.0.0' \
    -H 'content-type: application/json;charset=UTF-8' \
    -H 'accept: application/json, text/plain, */*' \
    -H 'cache-control: no-cache' \
    --data-binary '{\"email\":\"#EMAIL#\",\"password\":\"#PASSWORD#\"}' --compressed";

$deleteApp = "curl '#DOMAIN#/application/backoffice_list/deleteapplication' \
    --silent \
    -c 'siberian-cookie.txt' \
    -H 'accept-encoding: gzip, deflate, br' \
    -H 'x-requested-with: XMLHttpRequest' \
    -H 'pragma: no-cache' \
    -H 'user-agent: Insomnia/1.0.0' \
    -H 'content-type: application/json;charset=UTF-8' \
    -H 'accept: application/json, text/plain, */*' \
    -H 'cache-control: no-cache'  \
    --data-binary '{\"appId\":\"#APP_ID#\"}' --compressed";


$email = readline('Backoffice user e-mail: ');
$password = readline('Backoffice user password: ');

// Replace vars in the request!
$builtRequest = str_replace(
    [
        '#DOMAIN#',
        '#EMAIL#',
        '#PASSWORD#'
    ],
    [
        $siberianDomain,
        $email,
        $password
    ],
    $login
);

$response;
exec($builtRequest, $response);

$response = json_decode(join("\n", $response));
if ($response->success == true) {
    $appIds = readline('App ids (coma separated): ');
    $confirmation = readline('You are about to definitively delete all the Applications listed below, are you sure? (Y/n): ');
    if ($confirmation != 'Y') {
        echo 'Aborting batch delete.' . PHP_EOL;
        die();
    }

    $apps = explode(',', $appIds);
    foreach ($apps as $appId) {
        $builtDeleteRequest = str_replace(
            [
                '#DOMAIN#',
                '#APP_ID#'
            ],
            [
                $siberianDomain,
                $appId
            ],
            $deleteApp
        );

        $response = null;
        exec($builtDeleteRequest, $response);

        $response = json_decode(join("\n", $response));
        echo $response->message . PHP_EOL;
    }
}

// Clean-up cookie!
unlink('siberian-cookie.txt');

