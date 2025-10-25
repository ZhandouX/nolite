<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggleWishlist($produkId)
    {
        $user = Auth::user();

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('produk_id', $produkId)
            ->first();

        if ($wishlist) {
            $wishlist->delete(); // jika sudah ada, hapus (unwishlist)
            $status = 'removed';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'produk_id' => $produkId,
            ]);
            $status = 'added';
        }

        return response()->json(['status' => $status]);
    }

    public function index()
    {
        $wishlists = Wishlist::with('produk')->where('user_id', Auth::id())->get();
        return view('customer.wishlist', compact('wishlists'));
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
