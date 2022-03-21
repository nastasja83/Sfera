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
                        $skill_name = $skill->skill_name;
                        return view('skills.edit', compact('skill', 'skill_name'))->render();
                    })
                    ->orderColumn('skill_name', function ($query, $order) {
                        $query->orderBy('skill_name', $order);
                    })

                    ->editColumn('created_at', function ($skill) {
                        return $skill->created_at ? with(new Carbon($skill->created_at))->format('d-m-Y') : '';
                    })
                    ->addColumn('action', function($skill) {
                        $updateBtn = '<a href="'.route('skills.edit', $skill->id).'" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Update</a>';
                        $deleteBtn = '<a href="'.route('skills.destroy', $skill->id).'" class="btn btn-outline-danger btn-sm" data-method="delete" rel="nofollow" data-confirm="Are you sure?" aria-pressed="true">Delete</a>';
                            if (Auth::check() && Auth::user()->isAdmin()) {
                                return "{$updateBtn} {$deleteBtn}";
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
        //
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
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
