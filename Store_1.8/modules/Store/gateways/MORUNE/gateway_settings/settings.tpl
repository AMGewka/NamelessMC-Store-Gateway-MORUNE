<form action="" method="post">
    <div class="card shadow border-left-primary">
        <div class="card-body">
            <h5><i class="icon fa fa-info-circle"></i>{$GATEWAY_NAME}</h5></br>
            {$BANK_CARD}</br>
            {$ONLINE_PAYMENTS}</br>
            {$ONLINE_WALLET}</br>
            {$CRYPTOCURRENCIES}</br></br>
            {$GATEWAY_LINK}</br>
            {$ALERT_URL} <code>{$PINGBACK_URL}</code></br>
            {$SUCCESS_URL} <code>{$SUCC_URL}</code></br>
            {$FAILED_URL}
        </div>
    </div>
    <br />
    <div class="card shadow border-left-warning">
        <div class="card-body">
            <h5><i class="icon fa fa-info-circle"></i>{$WARINFO}</h5>
            {$INFO}
        </div>
    </div>
    <br />


<form action="" method="post"><div class="form-group"><label for="inputMORUNEuuId">{$SHOP_ID}</label>
<input class="form-control" type="text" id="inputMORUNEuuId" name="shopuuid_key" value="{$SHOP_UUID_VALUE}" placeholder="{$SHOP_ID}">
</div>

<div class="form-group"><label for="inputMORUNEApiKey">{$SHOP_KEY1}</label>
<input class="form-control" type="text" id="inputMORUNEApiKey" name="secret1_key" value="{$SHOP_API_KEY_VALUE}" placeholder="{$SHOP_KEY1}">
</div>

<div class="form-group"><label for="inputMORUNEApiKey2">{$SHOP_KEY2}</label>
<input class="form-control" type="text" id="inputMORUNEApiKey2" name="secret2_key" value="{$SHOP_API_KEY_2_VALUE}" placeholder="{$SHOP_KEY2}">
</div>

<div class="form-group"><label for="inputMORUNEhook">{$SHOP_URL_HOOK}</label>
<input class="form-control" type="text" id="inputMORUNEhook" name="morune_callb" value="{$MORUNE_CALLB}" placeholder="{$SHOP_URL_HOOK}">
</div>

<div class="form-group"><label for="inputMORUNEurlapi">{$MORUNE_URL}</label>
<input class="form-control" type="text" id="inputMORUNEurlapi" name="MORUNE_apiurl" value="{$MORUNE_URLAPI}" placeholder="{$MORUNE_URL}">
</div>

<div class="form-group custom-control custom-switch">
<input id="inputEnabled" name="enable" type="checkbox" class="custom-control-input"{if $ENABLE_VALUE eq 1} checked{/if} />
<label class="custom-control-label" for="inputEnabled">{$ENABLE_GATEWAY}</label>
</div>

<div class="form-group"><input type="hidden" name="token" value="{$TOKEN}"><input type="submit" value="{$SUBMIT}" class="btn btn-primary">
</div>
</form>