<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\SecurityServiceProvider());
$app['security.firewalls'] = array(
    'main' => array(
        'pattern' => '^/',
        'guard' => [
            'authenticators' => [
                'app.token_authenticator'
            ],

            // 'entry_point' => 'app.token_authenticator',
        ],
        'users' => array(
            // raw password is foo
            'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
        ),
        //'anonymous' => true,
    ),
);

$app['app.token_authenticator'] = function ($app) {
    return new App\TokenAuthenticator($app['security.encoder_factory']);
};

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

$app->run();
