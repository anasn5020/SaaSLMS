<?php
return [
    'secret' => saasEnv('NOCAPTCHA_SECRET'),
    'sitekey' => saasEnv('NOCAPTCHA_SITEKEY'),
    'options' => [
        'timeout' => 30,
    ],
    'for_login' => saasEnv('NOCAPTCHA_FOR_LOGIN', 'false'),
    'for_reg' => saasEnv('NOCAPTCHA_FOR_REG', 'false'),
    'for_contact' => saasEnv('NOCAPTCHA_FOR_CONTACT', 'false'),
    'is_invisible' => saasEnv('NOCAPTCHA_IS_INVISIBLE', 'false'),
];
