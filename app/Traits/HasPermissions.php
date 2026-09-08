<?php

namespace App\Traits;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;


trait HasPermissions
{
    /**
     * Check if user is authorized for a given ability.
     *
     * @param string $ability
     * @return void
     */
   
     public function authorizeAbility(string $ability)
     {
         try {
             Gate::authorize($ability);
         } catch (AuthorizationException $e) {
             return redirect()->route('admin.index')->with('error', 'معندكش الصلاحية تروح هنا')->send();
         }
     }
}
