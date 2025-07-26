<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        // Filter: today, week, month
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('date', now()->toDateString());
                break;

                case 'week':
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                break;

                case 'month':
                    $query->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
                break;
            }
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%']);
            });
        }

        $appointments = $query->with('user') // include relationships if needed
            ->orderBy('date', 'asc')
            ->paginate(20);

        return response()->json($appointments);
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('modify-appointment');

        $request->validate([
            'status' => 'required|string',
        ]);

        $appointment = Appointment::find($id);
        $appointment->update([
            'status' => $request->status
        ]);

        return $appointment;
    }

    public function destroy(Request $request)
    {
        Gate::authorize('modify-appointment');

        $request->validate([
            'id' => 'required|integer',
        ]);

        $appointment = Appointment::find($request->id);
        $appointment->delete();

        return $appointment;
    }
}
