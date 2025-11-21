<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use Illuminate\View\View;

class WishlistComposer
{
    public function compose(View $view)
    {
        $wishlistIds = [];

        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::id())
                ->pluck('produk_id')
                ->toArray();
        }

        // Inject ke semua view yang memakai composer ini
        $view->with('wishlistIds', $wishlistIds);
    }
}
