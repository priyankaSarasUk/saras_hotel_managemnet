<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Destroy an authenticated session (logout).
     *
     * This method handles the user's logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 1. Guard Logout: Logs out the user from the 'web' authentication guard.
        // This is the standard guard for browser-based authentication.
        Auth::guard('web')->logout();

        // 2. Invalidate Session: Invalidates the user's current session.
        // This helps prevent session hijacking.
        $request->session()->invalidate();

        // 3. Regenerate Token: Regenerates the CSRF token for security.
        // This is crucial to prevent Cross-Site Request Forgery attacks after logout.
        $request->session()->regenerateToken();

        // 4. Redirect: Redirects the user to the homepage or login page after logout.
        return redirect('/');
    }

    // ... other methods for login (create, store) would be in this file.
}
