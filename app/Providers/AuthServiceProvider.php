<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('check', function(User $user, array $data) {
            $condition = true;
            $rightEntity = $this->getRights($user);

            if (!$rightEntity) {
                $condition = false;
                return $condition;
            }

            $rights = $rightEntity->{$data['name']};

            if ($rights[$data['action']] === '-') {
                $condition = false;
            }

            if ($data['entity'] && $user->parent_id !== $data['entity']->user_id && $user->id !== $data['entity']->user_id) {
                $condition = false;
            }
            
            return $condition;
        });
    }

    private function getRights(User $user) {
        $rightEntity = $user->rights;

        if (!$rightEntity) {
            $parent = $user->parent;
            if ($parent) {
                $rightEntity = $parent->rights;
                if (!$rightEntity) {
                    $rightEntity = $user->group->rights;
                    if (!$rightEntity) {
                        return null;
                    }
                }
            } else {
                $rightEntity = $user->group->rights;
                if (!$rightEntity) {
                    return null;
                }
            }
        }     

        return $rightEntity;
    }
}
