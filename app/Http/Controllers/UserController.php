<?php

namespace App\Http\Controllers;

use App\User;
use App\Position;
use App\Skill;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
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
                        $editBtn = '<a href="users/'.$user->id.'/edit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Edit</a>';
                        $deleteBtn = '<a href="users/'.$user->id.'/delete" class="btn btn-outline-danger btn-sm" role="button" aria-pressed="true">Delete</a>';
                        if (Auth::user()->isAdmin()) {
                            return "{$editBtn} {$deleteBtn}";
                        } elseif (Auth::user()->id === $user->id) {
                            return $editBtn;
                        }
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

        return view('users.index', compact('position_names', 'skill_names'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $skills = Skill::pluck('skill_name', 'id')->sort()->all();
        $positions = Position::pluck('position_name', 'id')->sort()->all();
        $admin = $user->isAdmin();
        return view('users.edit', compact('user', 'skills', 'positions', 'admin'));
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
        $data = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'position_id' => 'nullable|integer',
            'skills' => 'nullable|array|max:5',
            'is_admin' => 'boolean|nullable',
            'phone' => 'required|regex:/^((\+79)[0-9]{9})?$/|size:12|unique:users,phone' . $user->id,
            'email' => 'required|email|max:255|unique:users,email' . $user->id,
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $user->fill($data);
        $user->save();

        $skills = collect($request->input('skills'))->filter(function ($skill) {
           return isset($skill);
        });
        $user->skills()->sync($skills);
        //flash(__('tasks.Task has been updated successfully'))->success();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->skills()->detach();
        $user->delete();

        //flash(__('users.User has been deleted successfully'))->success();
        return redirect()->route('users.index');
    }
}
