<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'product'])
            ->latest()
            ->paginate(15);

        return view('management.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('management.subscriptions.create', compact(
            'users',
            'products'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'status' => [
                'required',
                'in:pending,active,expired,cancelled,suspended'
            ],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'external_id' => ['nullable', 'string', 'max:255', 'unique:subscriptions,external_id'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        Subscription::create($validated);

        return redirect()
            ->route('management.subscriptions.index')
            ->with('success', 'تمت إضافة الاشتراك بنجاح.');
    }

    public function edit(Subscription $subscription)
    {
        $subscription->load(['user', 'product']);

        $users = User::orderBy('name')->get();

        $products = Product::orderBy('name')->get();

        return view('management.subscriptions.edit', compact(
            'subscription',
            'users',
            'products'
        ));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'status' => [
                'required',
                'in:pending,active,expired,cancelled,suspended'
            ],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'external_id' => [
                'nullable',
                'string',
                'max:255',
                'unique:subscriptions,external_id,' . $subscription->id
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $subscription->update($validated);

        return redirect()
            ->route('management.subscriptions.index')
            ->with('success', 'تم تحديث الاشتراك بنجاح.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()
            ->route('management.subscriptions.index')
            ->with('success', 'تم حذف الاشتراك بنجاح.');
    }
}