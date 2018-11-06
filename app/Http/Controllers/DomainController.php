<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckDomain;
use App\Http\Requests\StoreDomain;
use App\Http\Requests\UpdateDomain;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->with('domains')->first();
        $domains = Domain::withTrashed()->simplePaginate(5);
        return view('domains')->with(['user' => $user, 'domains' => $domains]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*    public function create()
        {
            //
        }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDomain $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDomain $request)
    {
        try {
            $domain = new Domain();
            $domain->domain = $request->domain;
            $domain->user_id = Auth::id();
            $domain->save();
            Session::flash('message', 'Added successfully.');
            Session::flash('alert-class', 'alert-success');
        } catch (\Exception $e) {
            Session::flash('message', 'Something went wrong');
            Session::flash('alert-class', 'alert-danger');
        }

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /*  public function show($id)
      {
          //
      }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = Domain::withTrashed()->where('id', $id)->first();
        return view('edit-domain')->with('domain', $domain);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDomain $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDomain $request, $id)
    {
        $domain = Domain::withTrashed()->where('id', $id)->first();
        try {
            if ($domain) {
                $domain->domain = $request->domain;
                $domain->save();
                return response()->json(['status' => 200, 'message' => 'Updated successfully.']);
            } else {
                return response()->json(['status' => 404, 'message' => 'Domain not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 403, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $domain = Domain::where('id', $id)->first();
            if ($domain) {
                $domain->delete();
                return response()->json(['status' => 200, 'message' => 'Deleted successfully.']);
            } else {
                return response()->json(['status' => 404, 'message' => 'Domain not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 403, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Restore the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function restore($id)
    {
        try {
            $domain = Domain::withTrashed()->where('id', $id)->first();
            if ($domain) {
                $domain->restore();
                return response()->json(['status' => 200, 'message' => 'Restored successfully.']);
            } else {
                return response()->json(['status' => 404, 'message' => 'Domain not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 403, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Check existence of the specified resource.
     *
     * @param CheckDomain $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function check(CheckDomain $request)
    {
        $domains = Domain::withTrashed()->where('domain', $request->domain)->get();
        if (count($domains) > 0) {
            return response()->json(['status' => 200, 'message' => 'Domain already exists.']);
        } else {
            return response()->json(['status' => 404, 'message' => 'Available']);
        }
    }
}
