<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function view()
    {
        $users = User::get();
        return view('adminView', compact('users'));
    }

    public function dataTables(Request $request)
    {
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay() ?? now()->startOfDay();
        $date_to = Carbon::parse($request->get('date_to'))->endOfDay();
        $user_id = $request->get('user_id');

        $exchange = Exchange::query();
        $exchange->when(!empty($date_from), function ($query) use ($date_from) {
            return $query->where('created_at', '>=', $date_from);
        });
        $exchange->when(!empty($date_to), function ($query) use ($date_to) {
            return $query->where('created_at', '<=', $date_to);
        });
        $exchange->when(!empty($user_id), function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });

        return datatables()->eloquent($exchange->with('users'))
            ->addColumn('name', function ($user) {
                if (!empty($user->users['name'])) {
                    $result = $user->users['name'];
                } else {
                    $result = 'No Username';
                }
                return $result;
            })
            ->make(true);
    }

    public function transactionsView()
    {
        $users = User::get();
        return view('transactions', compact('users'));
    }

    public function transactionsDatatables(Request $request)
    {
        $date_from = Carbon::parse($request->get('date_from'))->startOfDay() ?? now()->startOfDay();
        $date_to = Carbon::parse($request->get('date_to'))->endOfDay();
        $user_id = $request->get('user_id');

        $exchange = Transactions::query();
        $exchange->when(!empty($date_from), function ($query) use ($date_from) {
            return $query->where('created_at', '>=', $date_from);
        });
        $exchange->when(!empty($date_to), function ($query) use ($date_to) {
            return $query->where('created_at', '<=', $date_to);
        });
        $exchange->when(!empty($user_id), function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });

        return datatables()->eloquent($exchange)
            ->make(true);
    }
}
