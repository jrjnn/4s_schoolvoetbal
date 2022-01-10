<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Match;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * //     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wedstrijden = Match::all();
        return view('pages.events')
            ->with(compact('wedstrijden'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        $users = User::all();
        $fields = Field::all();
        return view('admin.wedstrijden.create')
            ->with(['teams' => $teams, 'users' => $users, 'fields' => $fields]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'team1' => 'required',
            'team2' => 'required|different:team1',
            'datum' => 'required|date',
            'scheidsrechter' => 'required',
            'veld' => 'required'
        ]);

        $wedstrijd = new Match();
        $wedstrijd->title = $request->title;
        $wedstrijd->team1_id = $request->team1;
        $wedstrijd->team2_id = $request->team2;
        $wedstrijd->datum = $request->datum;
        $wedstrijd->scheidsrechter_id = $request->scheidsrechter;
        $wedstrijd->field_id = $request->veld;
        $wedstrijd->save();

        return redirect()->route('wedstrijden.index')
            ->with('success', 'Wedstrijd succesvol aangemaakt');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wedstrijd = Match::findOrFail($id);
//        $teams = Team::all();
        return view('admin.wedstrijden.show')
            ->with(['wedstrijd' => $wedstrijd]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * //     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wedstrijd = Match::findOrFail($id);
        $teams = Team::all();
        $users = User::all();
        $fields = Field::all();
        return view('admin.wedstrijden.edit')
            ->with(['wedstrijd' => $wedstrijd, 'teams' => $teams, 'users' => $users, 'fields' => $fields]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'team1' => 'required',
            'team2' => 'required|different:team1',
            'datum' => 'required|date',
            'scheidsrechter' => 'required',
            'veld' => 'required'
        ]);

        $wedstrijd = Match::findOrFail($id);
        $wedstrijd->title = $request->title;
        $wedstrijd->team1_id = $request->team1;
        $wedstrijd->team2_id = $request->team2;
        $wedstrijd->datum = $request->datum;
        $wedstrijd->scheidsrechter_id = $request->scheidsrechter;
        $wedstrijd->field_id = $request->veld;
        $wedstrijd->status = $request->status;

        if ((isset($request->score_team1) || isset($request->score_team2)) && !$wedstrijd->is_bewerkt) {
            $wedstrijd->is_bewerkt = true;
            $wedstrijd->score_team1 = $request->score_team1;
            $wedstrijd->score_team2 = $request->score_team2;
        }

        $wedstrijd->save();


        return redirect()->route('wedstrijden.index')
            ->with('success', 'Wedstrijd succesvol aangepast');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wedstrijd = Match::destroy($id);

        return redirect()->route('wedstrijden.index')
            ->with('success', 'Wedstrijd succesvol verwijderd');
    }
}
