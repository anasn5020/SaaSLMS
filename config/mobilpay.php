<?php

return [
    'merchant_id' => getPaymentEnv('MOBILPAY_MERCHANT_ID'),
    'public_key_path' => getPaymentEnv('MOBILPAY_PUBLIC_KEY_PATH'),
    'private_key_path' => getPaymentEnv('MOBILPAY_PRIVATE_KEY_PATH'),
    'testMode' => getPaymentEnv('MOBILPAY_TEST_MODE'),
    'currency' => 'RON',
    'confirm_url' => getPaymentEnv('MOBILPAY_CONFIRM_URL'),
    'cancel_url' => getPaymentEnv('MOBILPAY_CANCEL_URL'),
    'return_url' => getPaymentEnv('MOBILPAY_RETURN_URL'),
];
