<?php

return [
    'stand_alone_mode' => filter_var(env('STAND_ALONE_MODE', false), FILTER_VALIDATE_BOOLEAN),
    'api_base_url' => env('IHRIS_API_BASE_URL', 'https://ihris.bayambang.gov.ph/api'),
    'login_endpoint' => env('IHRIS_LOGIN_ENDPOINT', '/login'),
    'default_api_user_role' => env('IHRIS_DEFAULT_API_USER_ROLE', 'Employee'),
];
