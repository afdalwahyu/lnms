<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\User;

Route::get('lol',function(){
  $user = new User;
  $user->name = 'afdal';
  $user->email = 'afdalwahyu@gmail.com';
  $user->username = 'afdalwahyu';
  $user->password = bcrypt('test');
  $user->save();
});

// temporary disable register and password pages
Route::get('auth/register', function() {
    return 'disabled';
});

Route::post('auth/register', function() {
    return 'disabled';
});

//	'password' => 'Auth\PasswordController',

Route::controllers([
	'auth' => 'Auth\AuthController',
]);

Route::get('home', 'PagesController@home');
Route::get('search', 'PagesController@search');
Route::get('bssid_clients', 'PagesController@bssid_clients');
Route::get('/', 'PagesController@home');

Route::get('nodes/{id}/test',       'NodesController@test');
Route::get('nodes/{id}/discover',   'NodesController@discover');
Route::get('nodes/{id}/ports',      'NodesController@ports');
Route::get('nodes/{id}/vlans',      'NodesController@vlans');
Route::get('nodes/{id}/macs',       'NodesController@macs');
Route::get('nodes/{id}/ips',        'NodesController@ips');
Route::get('nodes/{id}/arps',       'NodesController@arps');
Route::get('nodes/{id}/routes',     'NodesController@routes');
Route::get('nodes/{id}/bssids',     'NodesController@bssids');
Route::get('nodes/{id}/bssid_clients',     'NodesController@bssid_clients');
Route::get('nodes/{id}/graph_ping', 'NodesController@graph_ping');
Route::get('nodes/{id}/graph_snmp', 'NodesController@graph_snmp');
Route::patch('nodes/{id}/discover', 'NodesController@discover_update');
Route::patch('nodes/{id}/ports',    'NodesController@ports_update');
Route::resource('nodes', 'NodesController');

Route::get('ports/{id}', 'PortsController@show');
Route::get('ports/{id}/pollings', 'PortsController@pollings');
Route::patch('ports/{id}/pollings', 'PortsController@pollings_update');

Route::get('ports/{id}/octets', 'PortsController@octets');
Route::get('ports/{id}/octets_data', 'PortsController@octets_data');

Route::resource('locations', 'LocationsController');
Route::get('projects/{id}/logo', 'ProjectsController@logo');
Route::resource('projects', 'ProjectsController');
Route::resource('nodegroups', 'NodegroupsController');
Route::resource('users', 'UsersController');
Route::resource('usergroups', 'UsergroupsController');
Route::resource('permissions', 'PermissionsController');
Route::resource('roles', 'RolesController');

Route::get('pollings/{id}/ds', 'PollingsController@ds');

// bssids
Route::get('bssids', 'BssidsController@index');

// api
Route::get('api/v1/nodes/{id}/ping', 'NodesController@ping');
Route::get('api/v1/nodes/{id}/snmp', 'NodesController@snmp');
Route::get('api/v1/nodes/{ip}/status', 'NodesController@api_status');

// Dashboard
Route::get('dashboard_by_location', 'PagesController@dashboard_by_location');
Route::get('dashboard_by_project',  'PagesController@dashboard_by_project');
Route::get('dashboard_by_ssid',     'PagesController@dashboard_by_ssid');
Route::get('dashboard_by_clients',  'PagesController@dashboard_by_clients');
