<?php

return [
    'name' => 'Coinbase',
    'apiKey' => getPaymentEnv('COINBASE_API_KEY'),
    'apiVersion' => getPaymentEnv('COINBASE_API_VERSION'),

    'webhookSecret' => getPaymentEnv('COINBASE_WEBHOOK_SECRET'),
    'webhookJobs' => [
        'charge:created' => \Modules\Coinbase\Jobs\HandleCreatedCharge::class,
        'charge:confirmed' => \Modules\Coinbase\Jobs\HandleConfirmedCharge::class,

    ],
    'webhookModel' => Shakurov\Coinbase\Models\CoinbaseWebhookCall::class,
];
