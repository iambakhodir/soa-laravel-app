<?php

namespace App\Http\Controllers;

use App\Services\Activities\ActivityService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getActivity(Request $request)
    {
        $page = $request->get('page', 0);
        $items = (new ActivityService())->show($page);

        return view('admin.activity', compact('items'));
    }
}