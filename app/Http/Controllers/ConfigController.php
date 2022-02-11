<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $configs = Config::all();
        return view('config.index', compact('configs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigRequest $request, Config $config) {
        $this->authorize('create', $config);
        Config::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config) {
        return view('config.show', compact('config'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Config $config) {
        return view('config.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigRequest $request, Config $config) {
        $this->authorize('update', $config);
        $config->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Config $config) {
        $this->authorize('delete', $config);
        $config->delete();
    }
}
