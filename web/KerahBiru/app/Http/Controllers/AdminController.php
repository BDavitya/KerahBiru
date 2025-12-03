<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worker;
use App\Models\Order;
use App\Models\WorkerSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username === 'admin' && $request->password === 'admin') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_workers' => Worker::where('approval_status', 'approved')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
        ];

        $recent_orders = Order::with(['user', 'worker'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $top_workers = Worker::where('approval_status', 'approved')
            ->where('total_orders', '>', 0)
            ->orderBy('rating', 'desc')
            ->orderBy('total_orders', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_workers'));
    }

    // USERS
    public function users(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function userShow($id)
    {
        $user = User::with('orders.worker')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'latitude', 'longitude']));

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('users', 'public');
            $user->save();
        }

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate!');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }

    // WORKERS
    public function workers(Request $request)
    {
        $query = Worker::orderBy('created_at', 'desc');
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('approval_status', $request->status);
        }
        
        $workers = $query->paginate(20);
        return view('admin.workers.index', compact('workers'));
    }

    public function workerCreate()
    {
        return view('admin.workers.create');
    }

    public function workerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'price_per_hour' => 'required|numeric|min:0',
            'phone' => 'required|string',
            'whatsapp' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('photo');
        $data['rating'] = 0;
        $data['total_orders'] = 0;
        $data['is_available'] = true;
        $data['approval_status'] = 'approved';

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('workers', 'public');
        }

        $worker = Worker::create($data);

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $timeSlots = ['08:00-10:00', '10:00-12:00', '13:00-15:00', '15:00-17:00'];

        foreach ($days as $day) {
            foreach ($timeSlots as $slot) {
                WorkerSchedule::create([
                    'worker_id' => $worker->id,
                    'day' => $day,
                    'time_slot' => $slot,
                    'is_available' => true,
                ]);
            }
        }

        return redirect()->route('admin.workers')->with('success', 'Worker berhasil ditambahkan!');
    }

    public function workerShow($id)
    {
        $worker = Worker::with(['schedules', 'orders.user'])->findOrFail($id);
        return view('admin.workers.show', compact('worker'));
    }

    public function workerEdit($id)
    {
        $worker = Worker::findOrFail($id);
        return view('admin.workers.edit', compact('worker'));
    }

    public function workerUpdate(Request $request, $id)
    {
        $worker = Worker::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'price_per_hour' => 'required|numeric|min:0',
            'phone' => 'required|string',
            'whatsapp' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'nullable|image|max:5120',
        ]);

        $worker->update($request->except('photo'));

        if ($request->hasFile('photo')) {
            if ($worker->photo) {
                Storage::disk('public')->delete($worker->photo);
            }
            $worker->photo = $request->file('photo')->store('workers', 'public');
            $worker->save();
        }

        return redirect()->route('admin.workers')->with('success', 'Worker berhasil diupdate!');
    }

    public function workerDelete($id)
    {
        $worker = Worker::findOrFail($id);
        if ($worker->photo) {
            Storage::disk('public')->delete($worker->photo);
        }
        $worker->schedules()->delete();
        $worker->delete();
        return redirect()->route('admin.workers')->with('success', 'Worker berhasil dihapus!');
    }

    public function workerApprove($id)
    {
        $worker = Worker::findOrFail($id);
        $worker->update(['approval_status' => 'approved']);
        return back()->with('success', 'Worker berhasil disetujui!');
    }

    public function workerReject($id)
    {
        $worker = Worker::findOrFail($id);
        $worker->update(['approval_status' => 'rejected']);
        return back()->with('success', 'Worker ditolak!');
    }

    // ORDERS
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'worker'])
            ->orderBy('created_at', 'desc');
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('worker', function($workerQuery) use ($search) {
                    $workerQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('job_title', 'like', "%{$search}%");
                });
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderShow($id)
    {
        $order = Order::with(['user', 'worker'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function orderDelete($id)
    {
        $order = Order::findOrFail($id);
        if ($order->photo_before) {
            Storage::disk('public')->delete($order->photo_before);
        }
        if ($order->photo_after) {
            Storage::disk('public')->delete($order->photo_after);
        }
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order berhasil dihapus!');
    }

    public function orderConfirm($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'accepted']);
        return back()->with('success', 'Pesanan dikonfirmasi!');
    }

    public function orderCancel($id)
    {
        $order = Order::findOrFail($id);
        
        // Release schedule if booked
        if ($order->order_date && $order->time_slot) {
            $dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $day = $dayName[$order->order_date->dayOfWeek];
            
            WorkerSchedule::where('worker_id', $order->worker_id)
                ->where('day', $day)
                ->where('time_slot', $order->time_slot)
                ->where('booked_date', $order->order_date)
                ->update(['is_booked' => false, 'booked_date' => null]);
        }
        
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Pesanan dibatalkan!');
    }

    // SCHEDULES
    public function schedules($workerId)
    {
        $worker = Worker::findOrFail($workerId);
        $schedules = WorkerSchedule::where('worker_id', $workerId)
            ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get()
            ->groupBy('day');
        
        return view('admin.schedules.index', compact('worker', 'schedules'));
    }

    public function scheduleToggle(Request $request, $id)
    {
        $schedule = WorkerSchedule::findOrFail($id);
        $schedule->is_available = !$schedule->is_available;
        $schedule->save();

        return back()->with('success', 'Schedule updated!');
    }
}