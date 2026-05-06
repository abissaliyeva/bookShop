<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Storage;
// use App\Models\Book;
// use App\Mail\OrderConfirmationEmail;

// class BookController extends Controller
// {
//     public function index()
//     {
//         $books = Book::latest()->paginate(12);
//         return view('books.index', compact('books'));
//     }

//     public function store(Request $request)
//     {
//         if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
//             abort(403, 'Access denied.');
//         }

//         $data = $request->validate([
//             'title'       => 'required|string|max:255',
//             'author'      => 'required|string|max:255',
//             'price'       => 'required|numeric|min:0',
//             'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//         ]);

//         if ($request->hasFile('cover_image')) {
//             // Saves to storage/app/public/books/ and returns "books/filename.jpg"
//             $data['cover_image'] = $request->file('cover_image')
//                                            ->store('books', 'public');
//         }

//         $book = Book::create($data);

//         return back()->with('success', __('messages.book_added', ['title' => $book->title]));
//     }

//     public function show(Book $book)
//     {
//         return view('books.show', compact('book'));
//     }

//     public function edit(Book $book)
//     {
//         if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
//             abort(403, 'Access denied.');
//         }

//         return view('books.edit', compact('book'));
//     }

//     public function update(Request $request, Book $book)
//     {
//         if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
//             abort(403, 'Access denied.');
//         }

//         $data = $request->validate([
//             'title'       => 'required|string|max:255',
//             'author'      => 'required|string|max:255',
//             'price'       => 'required|numeric|min:0',
//             'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//         ]);

//         if ($request->hasFile('cover_image')) {
//             // Delete old image from storage before saving new one
//             if ($book->cover_image) {
//                 Storage::disk('public')->delete($book->cover_image);
//             }
//             $data['cover_image'] = $request->file('cover_image')
//                                            ->store('books', 'public');
//         }

//         $book->update($data);

//         return redirect()->route('books.index')
//                  ->with('success', __('messages.book_updated', ['title' => $book->title]));
//     }

//     public function destroy(Book $book)
//     {
//         if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
//             abort(403, 'Access denied.');
//         }

//         if ($book->cover_image) {
//             Storage::disk('public')->delete($book->cover_image);
//         }

//         $title = $book->title;
//         $book->delete();

//         return back()->with('success', __('messages.book_deleted', ['title' => $title]));
//     }

//     public function buy(Book $book)
//     {
//         if (!Auth::check()) {
//             return back()->with('error', __('messages.account_suspended'));
//         }

//         $user = Auth::user();

//         if ($user->is_banned) {
//             return back()->with('error', 'Your account is suspended.');
//         }

//         if (!$user->hasPermissionTo('buy books')) {
//             abort(403, 'Access denied.');
//         }

//         // Send order confirmation email
//         Mail::to($user->email)->send(new OrderConfirmationEmail($user, $book));

//         return back()->with('success', __('messages.bought_success', ['title' => $book->title]));
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\Order;
use App\Mail\OrderConfirmationEmail;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        $books = $query->latest()->paginate(12)->withQueryString();

        return view('books.index', compact('books'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
            abort(403);
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                                           ->store('books', 'public');
        }

        $book = Book::create($data);

        return back()->with('success', __('messages.book_added', ['title' => $book->title]));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'    ));
    }

    public function edit(Book $book)
    {
        if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
            abort(403);
        }

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
            abort(403);
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                                           ->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')
                         ->with('success', __('messages.book_updated', ['title' => $book->title]));
    }

    public function destroy(Book $book)
    {
        if (!Auth::check() || !Auth::user()->hasPermissionTo('manage books')) {
            abort(403);
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $title = $book->title;
        $book->delete();

        return back()->with('success', __('messages.book_deleted', ['title' => $title]));
    }

    public function buy(Book $book)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->is_banned) {
            return back()->with('error', __('messages.account_suspended'));
        }

        if (!$user->hasPermissionTo('buy books')) {
            abort(403);
        }

        // Save order to database
        Order::create([
            'user_id'    => $user->id,
            'book_id'    => $book->id,
            'price_paid' => $book->price,
        ]);

        Mail::to($user->email)->send(new OrderConfirmationEmail($user, $book));

        return back()->with('success', __('messages.bought_success', ['title' => $book->title]));
    }
}