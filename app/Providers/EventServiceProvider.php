<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // SAML2でログインした場合のイベント
        \Event::listen('Aacotroneo\Saml2\Events\Saml2LoginEvent', function ($event) {

            $user = $event->getSaml2User();

//            $userData = [
//                'id' => $user->getUserId(),
//                'attributes' => $user->getAttributes(),
//                'assertion' => $user->getRawSamlAssertion()
//            ];

            // ToDo: フィールド名固定で問題無いか
            $laravelUser = \App\User::where('email', $user->getUserId())
                ->first();

            // ToDo: Laravel側にいないユーザの場合、処理をどうするか
            if ($laravelUser) {
                \Auth::login($laravelUser);
            }

        });

        // SAML2でログアウトした場合のイベント
        \Event::listen('Aacotroneo\Saml2\Events\Saml2LogoutEvent', function ($event) {
            \Auth::logout();
        });
    }
}
