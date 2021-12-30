<?php
return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'user.passwordMinLength' => 8,
    'cookieDomain' => '.example.com',
    'frontendHostInfo' => 'http://frontend.shop.test',
    'backendHostInfo' => 'http://backend.shop.test',
    'staticHostInfo' => 'http://static.shop.test',
    'staticPath' => dirname(__DIR__, 2) . '/static',
];
