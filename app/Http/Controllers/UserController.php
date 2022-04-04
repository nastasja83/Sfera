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
                    ->addColumn('online', function ($user) {
                        if ($user->isOnline()) {
                            return '<i class="bi bi-check-circle-fill text-primary"></i>';
                        }
                        return '<i class="bi bi-check-circle"></i>';
                    })

                    ->addColumn('action', function ($user) {
                        return view('users.action_buttons', compact('user'))->render();
                    })
                    ->rawColumns(['action', 'online', 'skills'])
                    ->make(true);
        }
        $position_names = Position::all()->pluck('position_name')->sort();
        $skill_names = Skill::all()->pluck('skill_name')->sort();

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
            'phone' => 'required|regex:/^((\+79)[0-9]{9})?$/|size:12|unique:users,phone,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], $messages = [
            'max' => __('validation.The name should be no more than :max characters'),
            'regex' => __('validation.The phone should contain 12 characters and begin with +7'),
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

        flash(__('users.User has been updated successfully'))->success();

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
