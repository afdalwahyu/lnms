<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

    /*
     * Constructor
     *
     */
    public function __construct()
    {
        // must auth before
        $this->middleware('auth');
    }

	/**
     *
     */
    public function home() {

        // summary by location
        $locations = \App\Location::where('parent_id', 0)
                                  ->orderBy('name')->get();

        for ($i=0; $i<count($locations); $i++) {

            $nodesAll = \App\Node::where('location_id', $locations[$i]->id)->get();

            $nodesUp = \App\Node::where('location_id', $locations[$i]->id)
                                ->where('ping_success', '100')
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
                                ->get();

            $projects[$i]->nodesUp   = $nodesUp->count();
            $projects[$i]->nodesDown = $nodesAll->count() - $nodesUp->count();

        }

        // summary by nodegroup
        $nodegroups = \App\Nodegroup::orderBy('name')->get();

        for ($i=0; $i<count($nodegroups); $i++) {

            $nodesAll = \App\Node::where('nodegroup_id', $nodegroups[$i]->id)->get();

            $nodesUp = \App\Node::where('nodegroup_id', $nodegroups[$i]->id)
                                ->where('ping_success', '100')
                                ->get();

            $nodegroups[$i]->nodesUp   = $nodesUp->count();
            $nodegroups[$i]->nodesDown = $nodesAll->count() - $nodesUp->count();

        }

        return view('pages.home', compact('locations', 'projects', 'nodegroups', 'bssids'));
    }

    /**
     *
     * @return view
     */
    public function dashboard_by_location()
    {
        // summary by location
        $locations = \App\Location::where('parent_id', 0)
                                  ->orderBy('name')->get();

        for ($i=0; $i<count($locations); $i++) {

            $nodesAll = \App\Node::where('location_id', $locations[$i]->id)->get();

            $nodesUp = \App\Node::where('location_id', $locations[$i]->id)
                                ->where('ping_success', '100')
                                ->get();

            $locations[$i]->nodesUp   = $nodesUp->count();
            $locations[$i]->nodesDown = $nodesAll->count() - $nodesUp->count();

            // no node assigned in this project
            if ($nodesAll->count() == 0) {
                $locations[$i]->nodesUpnPercent  = 0;
                $locations[$i]->nodesDownPercent = 0;
            } else {

                $locations[$i]->nodesUpPercent   = ($nodesUp->count() / $nodesAll->count()) * 100;
                $locations[$i]->nodesDownPercent = 100 - $locations[$i]->nodesUpPercent;
    
                // to prevent too small click area
                if ($locations[$i]->nodesDownPercent > 0 && $locations[$i]->nodesDownPercent < 10) {
                    $locations[$i]->nodesUpPercent   -= 10;
                    $locations[$i]->nodesDownPercent += 10;
                }
    
                if ( $locations[$i]->nodesUpPercent > 0 && $locations[$i]->nodesUpPercent < 10) {
                    $locations[$i]->nodesUpPercent    += 10;
                    $locations[$i]->nodesDownPercent  -= 10;
                }
            }

        }

        return view('pages.dashboard_by_location', compact('locations'));
    }

    /**
     *
     * @return view
     */
    public function dashboard_by_project()
    {
        // summary by project
        $projects = \App\Project::orderBy('name')->get();

        for ($i=0; $i<count($projects); $i++) {

            $nodesAll = \App\Node::where('project_id', $projects[$i]->id)->get();

            $nodesUp = \App\Node::where('project_id', $projects[$i]->id)
                                ->where('ping_success', '100')
                                ->get();

            $projects[$i]->nodesUp   = $nodesUp->count();
            $projects[$i]->nodesDown = $nodesAll->count() - $nodesUp->count();

            // no node assigned in this project
            if ($nodesAll->count() == 0) {
                $projects[$i]->nodesUpnPercent  = 0;
                $projects[$i]->nodesDownPercent = 0;
            } else {

                $projects[$i]->nodesUpPercent   = ($nodesUp->count() / $nodesAll->count()) * 100;
                $projects[$i]->nodesDownPercent = 100 - $projects[$i]->nodesUpPercent;
    
                // to prevent too small click area
                if ($projects[$i]->nodesDownPercent > 0 && $projects[$i]->nodesDownPercent < 10) {
                    $projects[$i]->nodesUpPercent   -= 10;
                    $projects[$i]->nodesDownPercent += 10;
                }
    
                if ( $projects[$i]->nodesUpPercent > 0 && $projects[$i]->nodesUpPercent < 10) {
                    $projects[$i]->nodesUpPercent    += 10;
                    $projects[$i]->nodesDownPercent  -= 10;
                }

            }
        }

        return view('pages.dashboard_by_project', compact('projects'));
    }

    /**
     *
     * @return view
     */
    public function dashboard_by_ssid()
    {
        // summary by bssid
        $bssids = \DB::table('bssids')
                     ->select('bssidName', \DB::raw('count(*) as bssidCount'))
                     ->where('bssidName', '<>', '')
                     ->groupBy('bssidName')
                     ->orderBy('bssidName')
                     ->get();

        return view('pages.dashboard_by_ssid', compact('bssids'));
    }

    /**
     *
     * @return view
     */
    public function dashboard_by_clients()
    {
        // summary by bssid
        $bssids = \App\Bssid::orderBy('bssidClients_count', 'desc')
                            ->paginate(10);

        return view('pages.dashboard_by_clients', compact('bssids'));
    }

    /**
     *
     * @return view
     */
    public function search()
    {
        return view('pages.search');
    }

    /**
     *
     * @return view
     */
    public function bssid_clients()
    {
        if ( \Request::has('q') ) {
            $q = trim(\Request::get('q'));
            $clients = \App\Bd::where('clientIpAddress',    'RLIKE', $q)
                              ->orWhere('clientMacAddress', 'RLIKE', $q)
                              ->orderBy('timestamp', 'desc')->paginate(10);
        } else {
            $clients = [];
            $q = '';
        }

        return view('pages.bssid_clients', compact('clients', 'q'));
    }

}
