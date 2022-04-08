<?php

namespace Modules\AddonsPro\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\AddonsPro\Providers\SettingAddonsProServiceProvider;

class AddonsProController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('addonspro::index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function settings()
    {
        $version = '2.9.1.1';

        $columna = false;
        if (Schema::hasColumn('addon_categories', 'minimum_qty')){
            $columna = true;
        }

        $columnb = false;
        if (Schema::hasColumn('addon_categories', 'maximum_qty')){
            $columnb = true;
        }

        $columnc = false;
        if (Schema::hasColumn('addon_categories', 'add_required')){
            $columnc = true;
        }

        $new_fields = ($columna && $columnb && $columnc ? true : false);
        return view('addonspro::settings', compact(['version', 'new_fields']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('addonspro::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('addonspro::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('addonspro::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function disableRequiredAddonCategory($id)
    {
        $addonCategory = \App\AddonCategory::where('id', $id)->firstOrFail();
        if ($addonCategory) {
            $addonCategory->toggleActive()->save();
            return redirect()->back()->with(['success' => 'Operation Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Something Went Wrong']);
        }
    }

}
