<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-6">Leaderboard</h1>

    <form action="{{ route('leaderboard.recalculate') }}" method="POST" class="mb-6">
        @csrf
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Re-calculate
        </button>
    </form>

    <form action="{{ route('leaderboard.index') }}" method="GET" class="mb-6">
        <div class="flex space-x-4 items-center">
            <input type="text" name="user_id" placeholder="Search by User ID" value="{{ request('user_id') }}" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:outline-none w-full max-w-xs" />
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                Search
            </button>
        </div>
    </form>

    <form action="{{ route('leaderboard.index') }}" method="GET" class="mb-6">
        <div class="flex space-x-4 items-center">
            <select name="filter" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:outline-none">
                <option value="all" @if(request('filter') == 'all') selected @endif>All Time</option>
                <option value="day" @if(request('filter') == 'day') selected @endif>Today</option>
                <option value="month" @if(request('filter') == 'month') selected @endif>This Month</option>
                <option value="year" @if(request('filter') == 'year') selected @endif>This Year</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                Filter
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700 border-b">Rank</th>
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700 border-b">User ID</th>
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700 border-b">Full Name</th>
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700 border-b">Total Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaderboard as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-6 text-sm text-gray-800 border-b">{{ $item->rank }}</td>
                        <td class="py-3 px-6 text-sm text-gray-800 border-b">{{ $item->user_id }}</td>
                        <td class="py-3 px-6 text-sm text-gray-800 border-b">{{ $item->full_name }}</td>
                        <td class="py-3 px-6 text-sm text-gray-800 border-b">{{ $item->total_points }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
