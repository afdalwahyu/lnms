<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

	/**
     *
     */
    public function home() {

        // summary by location
        $locations = \App\Location::orderBy('name')->get();

        for ($i=0; $i<count($locations); $i++) {

            $nodesAll = \App\Node::where('location_id', $locations[$i]->id)->get();

            $nodesUp = \App\Node::where('location_id', $locations[$i]->id)
                                ->where('ping_success', '100')
                                ->where('snmp_success', '100')
                                ->get();

            $locations[$i]->nodesUp   = $nodesUp->count();
            $locations[$i]->nodesDown = $nodesAll->count() - $nodesUp->count();

        }

        // summary by project
        $projects = \App\Project::orderBy('name')->get();

        for ($i=0; $i<count($projects); $i++) {

            $nodesAll = \App\Node::where('project_id', $projects[$i]->id)->get();

            $nodesUp = \App\Node::where('project_id', $projects[$i]->id)
                                ->where('ping_success', '100')
                                ->where('snmp_success', '100')
                                ->get();

            $projects[$i]->nodesUp   = $nodesUp->count();
            $projects[$i]->nodesDown = $nodesAll->count() - $nodesUp->count();

        }

        return view('pages.home', compact('locations', 'projects'));
    }

}
