<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Ambil semua wishlist milik user beserta produk & foto
        $wishlists = Wishlist::with(['produk.fotos'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile.edit', [
            'user' => $user,
            'wishlists' => $wishlists,
        ]);
    }

    public function remove($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        if ($wishlist->user_id == Auth::id()) {
            $wishlist->delete();
        }

        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /* SETTINGS */
    public function settings(Request $request)
    {
        return view('profile.settings', [
            'user' => $request->user(),
        ]);
    }
}
