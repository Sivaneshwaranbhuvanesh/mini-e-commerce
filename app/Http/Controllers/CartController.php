<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(AddToCartRequest $request, Product $product): RedirectResponse
    {
        if ($product->stock < 1) {
            return back()->with('error', 'This product is out of stock.');
        }

        $quantity = $request->quantity;
        $cart     = session()->get('cart', []);

        $currentQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;

        if (($currentQty + $quantity) > $product->stock) {
            return back()->with('error', "Only {$product->stock} item(s) available in stock.");
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', "'{$product->name}' added to cart!");
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:1']]);

        $product = Product::findOrFail($productId);
        $cart    = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
        }

        if ($request->quantity > $product->stock) {
            return back()->with('error', "Only {$product->stock} item(s) available in stock.");
        }

        $cart[$productId]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(int $productId): RedirectResponse
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}