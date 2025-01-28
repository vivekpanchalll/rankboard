<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
      
      public function index(Request $request)
      {
        
          $today = Carbon::today();
          $startOfMonth = Carbon::now()->startOfMonth();
          $startOfYear = Carbon::now()->startOfYear();
  
          
          $filter = $request->query('filter', 'all');
          $searchUserId = $request->query('user_id'); 
          
          $leaderboardQuery = DB::table('leaderboard')
              ->select('user_id', 'full_name', DB::raw('SUM(points) as total_points'))
              ->groupBy('user_id', 'full_name')
              ->orderByDesc('total_points');
  
          
          if ($filter == 'day') {
              $leaderboardQuery->whereDate('activity_date', $today); 
          } elseif ($filter == 'month') {
              $leaderboardQuery->whereBetween('activity_date', [$startOfMonth, Carbon::now()]); 
          } elseif ($filter == 'year') {
              $leaderboardQuery->whereBetween('activity_date', [$startOfYear, Carbon::now()]); 
          }
  
          if ($searchUserId) {
              $leaderboardQuery->where('user_id', $searchUserId);
          }
  
          
          $leaderboard = $leaderboardQuery->get()
              ->map(function ($item, $index) {
                  $item->rank = $index + 1;
                  return $item;
              });

          return view('leaderboard', compact('leaderboard', 'filter', 'searchUserId'));
      }
  
      public function recalculate()
      {
          
          $users = DB::table('users')->get(); 
  
          foreach ($users as $user) {
              for ($i = 0; $i < 20; $i++) {
                  DB::table('leaderboard')->insert([
                      'full_name' => $user->name,
                      'user_id' => $user->id,
                      'activity_date' => now()->subDays(rand(0, 30))->subMinutes(rand(0, 1440)),
                      'points' => rand(10, 99),
                      'created_at' => now(),
                      'updated_at' => now(),
                  ]);
              }
          }
  
          return redirect()->route('leaderboard.index')->with('success', 'Leaderboard has been recalculated!');
      }
  
}
