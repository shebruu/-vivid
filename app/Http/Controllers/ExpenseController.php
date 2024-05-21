<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Expense;

use App\Models\Category;

use App\Models\UserActivity;

use App\Models\Price;
use App\Models\Notification;

use App\Http\Requests\ExpenseRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{


    public function index($tripId)
    {
        $expenses = Expense::where('trip_id', $tripId)->get();
        return Inertia::render('Expenses/Index', compact('expenses'));
    }


    public function getRevisedActivitiesWithPrices($tripId)
    {
        $activities = DB::table('user_activities as ua')
            ->join('activities as act', 'ua.activity_id', '=', 'act.id')
            ->leftJoin('prices as pr', 'ua.place_id', '=', 'pr.place_id')
            ->leftJoin('places as pl', 'ua.place_id', '=', 'pl.id')
            ->join('trips as t', 'ua.trip_id', '=', 't.id')
            ->select(
                'ua.id as user_activity_id',
                'act.activity as activity_name',
                'ua.price_id',
                'pl.title as place_title',
                'ua.place_id',
                't.title as trip_title',
                DB::raw("GROUP_CONCAT(DISTINCT CONCAT(pr.amount, ' ', pr.age_rang, ' ', pr.season, ' ', pr.day_type) ORDER BY pr.amount DESC) as all_prices_at_place")
            )
            ->where('ua.status', 'revised')
            ->where('ua.trip_id', $tripId)
            ->groupBy('ua.id', 'act.activity', 'ua.price_id', 'pl.title', 'ua.place_id', 't.title')
            ->orderBy('t.title', 'asc')
            ->limit(25)
            ->get();



        // Retrieve participants for the trip
        $participants = DB::table('users')
            ->join('user_trip', 'users.id', '=', 'user_trip.user_id')
            ->where('user_trip.trip_id', $tripId)
            ->select('users.id', DB::raw("CONCAT(users.firstname, ' ', users.lastname) AS name"))
            ->get();

        $categories = Category::all();
        $currentUser = auth()->user();
        // dd($activities);
        // dd($participants);

        return inertia('Mycomponents/expenses/Create', [
            'activities' => $activities,
            'tripId' => $tripId,
            'users' => $participants,
            'categories' => $categories,
            'currentUser' => [
                'id' => $currentUser->id,
                'name' => $currentUser->firstname . ' ' . $currentUser->lastname
            ]
        ]);
    }

    public function create($tripId)
    {
        $categories = Category::all();
        return Inertia::render('Expenses/Create', [
            'categories' => $categories,
            'tripId' => $tripId
        ]);
    }

    public function store(Request $request, $tripId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'trip_id' => $tripId,
            'category_id' => $request->category_id,
            'amount' => $request->amount
        ]);

        return redirect()->route('expenses.index', ['tripId' => $tripId])->with('success', 'Expense added successfully.');
    }



    public function storeMultipleExpenses(ExpenseRequest $request, $tripId)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'expenses.*.price_id' => 'required|exists:prices,id',
            'expenses.*.user_id' => 'required|exists:users,id',
            'payment_link' => 'nullable|url'
        ]);
        $leisureCategory = Category::where('name', 'leisure')->firstOrFail();

        foreach ($data['expenses'] as $expenseData) {
            foreach ($expenseData['user_ids'] as $userId) {
                Expense::create([
                    'trip_id' => $tripId,
                    'price_id' => $expenseData['price_id'],
                    'user_id' => $userId,
                    'amount' => Price::find($expenseData['price_id'])->amount,
                    'category_id' => $leisureCategory->id
                ]);
            }
        }
        // sendPaymentNotification();

        return redirect()->route('expenses.index', ['tripId' => $tripId])->with('success', 'Expenses added successfully.');
    }


    public function sendPaymentNotification($userId, $amount, $senderId, $activityName)
    {
        $message = "Un paiement de $amount € a été effectué pour l'activité '$activityName'.";
        Notification::create([
            'sender_id' => $senderId,
            'user_id' => $userId,
            'message' => $message
        ]);
    }
}
