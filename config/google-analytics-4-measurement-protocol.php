<?php

return [
    'measurement_id' => saasEnv('MEASUREMENT_ID', null),

    'api_secret' => saasEnv('MEASUREMENT_PROTOCOL_API_SECRET', null),

    'client_id_session_key' => 'google-analytics-4-measurement-protocol.client_id'
];
