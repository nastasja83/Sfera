<?php

namespace App\Http\Controllers;

use App\User;
use App\Position;
use App\Skill;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Mail\MessageOfChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
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
                        return $user->position->position_name ?? "";
                    })
                    ->addColumn('online', function($user) {
                        if ($user->isOnline()) {
                            return '<i class="bi bi-check-circle-fill text-primary"></i>';
                        }
                        return '<i class="bi bi-check-circle"></i>';
                    })

                    ->addColumn('action', function($user) {
                        $editBtn = '<a href="'.route('users.edit', $user->id).'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Edit</a>';
                        $deleteBtn = '<a href="'.route('users.destroy', $user->id).'" class="btn btn-outline-danger btn-sm" data-method="delete" rel="nofollow" data-confirm="Are you sure?" aria-pressed="true">Delete</a>';
                        if (Auth::check()) {
                            if (Auth::user()->isAdmin()) {
                                return "{$editBtn} {$deleteBtn}";
                            } elseif (Auth::user()->id === $user->id) {
                                return $editBtn;
                            }
                        }
                    })
                    ->rawColumns(['action', 'online', 'skills'])
                    ->make(true);
        }
        $positions = Position::all();
        $position_names = $positions->map(function ($position) {
            return $position->position_name ?? "";
        })
        ->unique()
        ->sort()
        ->all();

        $skills = Skill::all();
        $skill_names = $skills->map(function ($skill) {
            return $skill->skill_name ?? "";
        })
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
            'max' => __('validation.The task name has already been taken'),
        ]);

        $userChange = collect($data)->diffAssoc($user)->only('position_id', 'is_admin');

        $user->fill($data);
        $user->save();

        $skills = collect($request->input('skills'))->filter(function ($skill) {
           return isset($skill);
        });

        $userSkillsId = collect($user->skills)->map(function ($skill) {
            return $skill->id;
        });

        $skillsChange = $userSkillsId === $skills ? [] : $skills;

        $user->skills()->sync($skills);
        $user->load('skills');

        flash(__('tasks.Task has been updated successfully'))->success();

        if ($userChange->isNotEmpty() || $skillsChange->isNotEmpty()) {
            Mail::to($user->email)->send(new MessageOfChange($user, $userChange, $skillsChange));
        }
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

        flash(__('users.User has been deleted successfully'))->success();
        return redirect()->route('users.index');
    }
}
