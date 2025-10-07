<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetHouseOwnerContext
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasRole('house_owner')) {
            $houseOwner = auth()->user()->houseOwner;

            if (!$houseOwner) {
                abort(403, 'House owner profile not found.');
            }

            // Share house owner data with all views
            view()->share('currentHouseOwner', $houseOwner);

            // Store in request for easy access in controllers
            $request->merge(['house_owner_id' => $houseOwner->id]);
        }

        return $next($request);
    }
}