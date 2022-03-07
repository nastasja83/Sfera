<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($user) {
                        return $user->created_at ? with(new Carbon($user->created_at))->format('d-m-Y') : '';
                    })
                    ->editColumn('skills', function ($user) {
                        $skill_names = $user->skills
                            ->pluck('skill_name')
                            ->map(function ($skill_name) {
                                return "<li>{$skill_name}</li>";
                            })
                            ->implode('');
                        return "<ul>{$skill_names}</ul>";
                    })
                    ->editColumn('position_name', function ($user) {
                        $position = $user->position;
                        return $position->position_name ?? "";
                    })
                    ->addColumn('online', function($user) {
                        if ($user->isOnline()) {
                            return '<i class="bi bi-check-circle-fill text-primary"></i>';
                        }
                        return '<i class="bi bi-check-circle"></i>';
                    })

                    ->addColumn('action', function($user) {
                        $editBtn = '<a href="#" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Edit</a>';
                        $deleteBtn = '<a href="#" class="btn btn-outline-danger btn-sm" role="button" aria-pressed="true">Delete</a>';
                        return "{$editBtn} {$deleteBtn}";
                    })
                    ->rawColumns(['action', 'online', 'skills'])
                    ->make(true);
        }
        $users = User::all();
        $position_names = $users->map(function ($user) {
            return $user->position->position_name ?? "";
        })
        ->unique()
        ->sort()
        ->all();

        $skill_names = $users->map(function ($user) {
            return $user->skills->pluck('skill_name');
        })
        ->flatten()
        ->unique()
        ->sort()
        ->all();

        return view('users', compact('position_names', 'skill_names'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
