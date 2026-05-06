<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use App\Models\Book;
// use Spatie\Permission\Models\Role;

// class RoleController extends Controller
// {
//     public function adminDashboard()
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('admin')) {
//             abort(403, 'Access denied.');
//         }

//         $users = User::with('roles')->latest()->get();
//         $books = Book::latest()->get();
//         $roles = Role::all();

//         return view('dashboards.admin', compact('users', 'books', 'roles'));
//     }

//     public function managerDashboard()
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('manager')) {
//             abort(403, 'Access denied.');
//         }

//         $books = Book::latest()->get();

//         return view('dashboards.manager', compact('books'));
//     }

//     public function moderatorDashboard()
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('moderator')) {
//             abort(403, 'Access denied.');
//         }

//         $users = User::with('roles')->latest()->get();

//         return view('dashboards.moderator', compact('users'));
//     }

//     public function customerDashboard()
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('customer')) {
//             abort(403, 'Access denied.');
//         }

//         $books = Book::latest()->get();

//         return view('dashboards.customer', compact('books'));
//     }

//     public function assignRole(Request $request, User $user)
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('admin')) {
//             abort(403, 'Access denied.');
//         }

//         $request->validate(['role' => 'required|exists:roles,name']);
//         $user->syncRoles([$request->role]);

//         return back()->with('success', "Role '{$request->role}' assigned to {$user->name}.");
//     }

//     public function adminToggleBan(User $user)
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('admin')) {
//             abort(403, 'Access denied.');
//         }

//         if ($user->hasRole('admin')) {
//             return back()->with('error', __('messages.cannot_ban_admin'));
//         }

//         $user->is_banned = !$user->is_banned;
//         $user->save();

//         $status = $user->is_banned ? __('messages.banned') : __('messages.active');
//         return back()->with('success', "{$user->name}: {$status}");
//     }

//     public function moderatorToggleBan(User $user)
//     {
//         if (!Auth::check() || !Auth::user()->hasRole('moderator')) {
//             abort(403, 'Access denied.');
//         }

//         if ($user->hasRole('admin') || $user->hasRole('moderator')) {
//             return back()->with('error', __('messages.mod_cannot_ban'));
//             return back()->with('error', 'Moderators cannot ban admins or other moderators.');
//         }

//         $user->is_banned = !$user->is_banned;
//         $user->save();

//         $status = $user->is_banned ? __('messages.banned') : __('messages.active');
//         return back()->with('success', "{$user->name}: {$status}");
//     }
// }



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;
use Spatie\Permission\Models\Role;
use App\Models\Order;

class RoleController extends Controller
{
    // ── Admin ──────────────────────────────────────────────────────────────
    public function adminDashboard()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) abort(403);

        $users = User::with('roles')->latest()->get();
        $books = Book::latest()->get();
        $roles = Role::all();

        return view('dashboards.admin', compact('users', 'books', 'roles'));
    }

    // ── Manager ────────────────────────────────────────────────────────────
    public function managerDashboard()
    {
        if (!Auth::check() || !Auth::user()->hasRole('manager')) abort(403);

        $books = Book::latest()->get();

        return view('dashboards.manager', compact('books'));
    }

    // ── Manager: orders page ───────────────────────────────────────────────
    public function managerOrders()
    {
        if (!Auth::check() || !Auth::user()->hasRole('manager')) abort(403);

        $orders = Order::with(['book', 'user'])->latest()->paginate(20);

        return view('manager.orders', compact('orders'));
    }

    // ── Moderator: main (stats) ────────────────────────────────────────────
    public function moderatorDashboard()
    {
        if (!Auth::check() || !Auth::user()->hasRole('moderator')) abort(403);

        $totalUsers    = User::count();
        $totalBooks    = Book::count();
        $bannedUsers   = User::where('is_banned', true)->count();
        $totalManagers = User::role('manager')->count();

        return view('dashboards.moderator', compact(
            'totalUsers', 'totalBooks', 'bannedUsers', 'totalManagers'
        ));
    }

    // ── Moderator: customers page ──────────────────────────────────────────
    public function moderatorCustomers()
    {
        if (!Auth::check() || !Auth::user()->hasRole('moderator')) abort(403);

        $customers = User::role('customer')->latest()->get();

        return view('moderator.customers', compact('customers'));
    }

    // ── Moderator: books page ──────────────────────────────────────────────
    public function moderatorBooks()
    {
        if (!Auth::check() || !Auth::user()->hasRole('moderator')) abort(403);

        $books = Book::latest()->get();

        return view('moderator.books', compact('books'));
    }

    // ── Moderator: managers page ───────────────────────────────────────────
    public function moderatorManagers()
    {
        if (!Auth::check() || !Auth::user()->hasRole('moderator')) abort(403);

        $managers = User::role('manager')->with('roles')->latest()->get();
        $roles    = Role::whereNotIn('name', ['admin'])->get();

        return view('moderator.managers', compact('managers', 'roles'));
    }

    // ── Customer ───────────────────────────────────────────────────────────
    public function customerDashboard()
    {
        if (!Auth::check() || !Auth::user()->hasRole('customer')) abort(403);

        $books = Book::latest()->paginate(12);

        return view('dashboards.customer', compact('books'));
    }

    // ── Admin: assign role ─────────────────────────────────────────────────
    public function assignRole(Request $request, User $user)
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) abort(403);

        $request->validate(['role' => 'required|exists:roles,name']);
        $user->syncRoles([$request->role]);

        return back()->with('success', "Role '{$request->role}' assigned to {$user->name}.");
    }

    // ── Admin: ban/unban ───────────────────────────────────────────────────
    public function adminToggleBan(User $user)
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) abort(403);

        if ($user->hasRole('admin')) {
            return back()->with('error', __('messages.cannot_ban_admin'));
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        return back()->with('success', $user->name . ': ' .
            ($user->is_banned ? __('messages.banned') : __('messages.active')));
    }

    // ── Moderator: ban/unban customers & managers ──────────────────────────
    public function moderatorToggleBan(User $user)
    {
        if (!Auth::check() || !Auth::user()->hasRole('moderator')) abort(403);

        if ($user->hasRole('admin') || $user->hasRole('moderator')) {
            return back()->with('error', __('messages.mod_cannot_ban'));
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        return back()->with('success', $user->name . ': ' .
            ($user->is_banned ? __('messages.banned') : __('messages.active')));
    }

    // ── Moderator: assign role to manager ──────────────────────────────────
    public function moderatorAssignRole(Request $request, User $user)
    {
        if (!Auth::check() || !Auth::user()->hasRole('moderator')) abort(403);

        // Moderators cannot assign admin role
        $request->validate(['role' => 'required|in:manager,moderator,customer']);
        $user->syncRoles([$request->role]);

        return back()->with('success', "Role '{$request->role}' assigned to {$user->name}.");
    }
}