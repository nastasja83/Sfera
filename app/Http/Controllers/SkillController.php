<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Skill::class, 'skill');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Skill::query();
            return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->editColumn('skill_name', function ($skill) {
                        return view('skills.edit', compact('skill'))->render();
                    })
                    ->orderColumn('skill_name', function ($query, $order) {
                        $query->orderBy('skill_name', $order);
                    })

                    ->editColumn('created_at', function ($skill) {
                        return $skill->created_at ? with(new Carbon($skill->created_at))->format('d-m-Y') : '';
                    })
                    ->addColumn('action', function($skill) {
                            if (Auth::check() && Auth::user()->isAdmin()) {
                                return view('skills.action_buttons', compact('skill'))->render();
                            }
                    })
                    ->rawColumns(['action', 'skill_name'])
                    ->make(true);
        }
        $skills = Skill::pluck('skill_name', 'id')->unique()->sort()->all();
        return view('skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skill = new Skill();
        return view('skills.create', compact('skill'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $skillInputData = $this->validate($request, [
            'skill_name' => 'required|max:255|unique:skills',
        ], $messages = [
            'unique' => __('validation.The skill name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);

        $skill = new Skill();
        $skill->fill($skillInputData);
        $skill->save();

        flash(__('skills.Skill has been added successfully'))->success();
        return redirect()
            ->route('skills.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $skillInputData = $this->validate($request, [
            'skill_name' => 'required|max:255|unique:skills,name,' . $skill->id,
        ], $messages = [
            'unique' => __('validation.The skill name has already been taken'),
            'max' => __('validation.The name should be no more than :max characters'),
        ]);

        $skill->fill($skillInputData);
        $skill->save();

        flash(__('skills.Skill has been updated successfully'))->success();
        return redirect()
            ->route('skills.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        if ($skill->users()->exists()) {
            flash(__('skills.Failed to delete skill'))->error();
            return back();
        }

        $skill->delete();
        flash(__('skills.Skill has been deleted successfully'))->success();
        return redirect()->route('skills.index');
    }
}
