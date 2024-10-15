<?php

/*
 *  Made by AMGewka
 *  https://github.com/AMGewka
 *
 *  License: MIT
 *
 *  Store module
 */
require_once(ROOT_PATH . '/modules/Store/classes/StoreConfig.php');
$morune_language = new Language(ROOT_PATH . '/modules/Store/gateways/MORUNE/language', LANGUAGE);

if (Input::exists()) {
    if (Token::check()) {
        if (isset($_POST['shopuuid_key']) && isset($_POST['secret1_key']) && isset($_POST['secret2_key']) && isset($_POST['morune_callb']) && isset($_POST['morune_apiurl']) && strlen($_POST['shopuuid_key']) && strlen($_POST['secret1_key']) && strlen($_POST['secret2_key']) && strlen($_POST['morune_callb']) && strlen($_POST['morune_apiurl'])) {
            StoreConfig::set('MORUNE.shopuuid_key', $_POST['shopuuid_key']);
            StoreConfig::set('MORUNE.secret1_key', $_POST['secret1_key']);
            StoreConfig::set('MORUNE.secret2_key', $_POST['secret2_key']);
            StoreConfig::set('MORUNE.morune_callb', $_POST['morune_callb']);
            StoreConfig::set('MORUNE.morune_apiurl', $_POST['morune_apiurl']);
        }

        //  Is this gateway enabled
        if (isset($_POST['enable']) && $_POST['enable'] == 'on') $enabled = 1;
        else $enabled = 0;

        DB::getInstance()->update('store_gateways', $gateway->getId(), [
            'enabled' => $enabled
        ]);

        Session::flash('gateways_success', $language->get('admin', 'successfully_updated'));
    } else
        $errors = [$language->get('general', 'invalid_token')];
}

$smarty->assign([
    'SETTINGS_TEMPLATE' => ROOT_PATH . '/modules/Store/gateways/MORUNE/gateway_settings/settings.tpl',
    'ENABLE_VALUE' => ((isset($enabled)) ? $enabled : $gateway->isEnabled()),
    'SHOP_UUID_VALUE' => ((isset($_POST['shopuuid_key']) && $_POST['shopuuid_key']) ? Output::getClean(Input::get('shopuuid_key')) : StoreConfig::get('MORUNE.shopuuid_key')),
    'SHOP_API_KEY_VALUE' => ((isset($_POST['secret1_key']) && $_POST['secret1_key']) ? Output::getClean(Input::get('secret1_key')) : StoreConfig::get('MORUNE.secret1_key')),
    'SHOP_API_KEY_2_VALUE' => ((isset($_POST['secret2_key']) && $_POST['secret2_key']) ? Output::getClean(Input::get('secret2_key')) : StoreConfig::get('MORUNE.secret2_key')),
    'MORUNE_CALLB' => ((isset($_POST['morune_callb']) && $_POST['morune_callb']) ? Output::getClean(Input::get('morune_callb')) : StoreConfig::get('MORUNE.morune_callb')),
    'MORUNE_URLAPI' => ((isset($_POST['morune_apiurl']) && $_POST['morune_apiurl']) ? Output::getClean(Input::get('morune_apiurl')) : StoreConfig::get('MORUNE.morune_apiurl')),
    'SHOP_ID' => $morune_language->get('shopid'),
    'SHOP_KEY1' => $morune_language->get('key1'),
    'SHOP_KEY2' => $morune_language->get('key2'),
    'SHOP_URL_HOOK' => $morune_language->get('shophookurl'),
    'ENABLE_GATEWAY' => $morune_language->get('enablegateway'),
    'GATEWAY_NAME' => $morune_language->get('gatewayname'),
    'BANK_CARD' => $morune_language->get('bankcard'),
    'ONLINE_WALLET' => $morune_language->get('onlinewal'),
    'CRYPTOCURRENCIES' => $morune_language->get('crypto'),
    'GATEWAY_LINK' => $morune_language->get('gatewaylink'),
    'GATEWAY_TESTED' => $morune_language->get('gatewaytest'),
    'ALERT_URL' => $morune_language->get('alerturl'),
    'SUCCESS_URL' => $morune_language->get('sucurl'),
    'FAILED_URL' => $morune_language->get('failurl'),
    'MORUNE_URL' => $morune_language->get('moruneapiurl')
]);