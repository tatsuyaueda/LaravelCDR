<?php namespace App\Providers;

use View; // Illuminate\Contracts\View\Factory
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * return void
     */
    public function boot()
    {

        View::composer('*', function ($view) {
            $loginUser = \Auth::user();

            if($loginUser){
                // Avatar
                switch ($loginUser->avatar_type){
                    case 0:
                        $path = \File::exists(storage_path('avatar/' . $loginUser->avatar_filename)) ? asset('storege/avatar/'. $loginUser->avatar_filename) : null;
                        $view->with('avater_image', $path ? $path  : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm');
                        break;
                    case 1:
                        $view->with('avater_image', 'https://www.gravatar.com/avatar/' . md5(strtolower($loginUser->email))  . '?d=mm');
                        break;
                }
            }
        });


    }

    /**
     * Register
     */
    public function register()
    {
    }
}
