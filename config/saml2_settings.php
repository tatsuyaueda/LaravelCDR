<?php

return $settings = array(

    'useSaml2Auth' => true,

    'useRoutes' => true,
    'routesPrefix' => '/saml2',
    'routesMiddleware' => ['saml'],
    'retrieveParametersFromServer' => false,

    'logoutRoute' => '/logout',
    'loginRoute' => '/cdr',
    'errorRoute' => '/auth/login',

    'strict' => true, //@todo: make this depend on laravel config
    'debug' => env('APP_DEBUG'),

    'sp' => array(
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        'x509cert' => env('SAML2_SP_CERT', ''),
        'privateKey' => env('SAML2_SP_KEY', ''),
    ),

    'idp' => array(
        'entityId' => env('SAML2_ENTITYID', ''),
        'singleSignOnService' => array(
            'url' => env('SAML2_SSOS', ''),
        ),
        'singleLogoutService' => array(
            'url' => env('SAML2_SLS', ''),
        ),
       'certFingerprint' => env('SAML2_IDP_FINGERPRINT', ''),
    ),

    'security' => array(
        'nameIdEncrypted' => false,
        'authnRequestsSigned' => true,
        'logoutRequestSigned' => false,
        'logoutResponseSigned' => false,
        'signMetadata' => false,
        'wantMessagesSigned' => false,
        'wantAssertionsSigned' => false,
        'wantNameIdEncrypted' => false,
        'requestedAuthnContext' => true,
    ),
);