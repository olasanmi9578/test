<?php

namespace App\Http\Controllers\ASanchez85;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ASanchez85\Roles\RoleResource;
use App\Http\Resources\ASanchez85\Roles\RoleCollection;
use App\Http\Requests\ASanchez85\Roles\RoleStoreRequest;
use App\Http\Requests\ASanchez85\Roles\RoleUpdateRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate();

        return new RoleCollection($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Este metodo no se usa;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create($request->all());

        $role->syncPermissions($request->get('permissions'));
            
        $success = $role->name . __(' it was created successfully.');

        return response()->json(['message' => $success], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrfail($id);

        return new RoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrfail($id);

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $role = Role::findOrfail($id);

        $role->update($request->all());

        $role->syncPermissions($request->get('permissions'));
            
        $success = $role->name . __(' It has been updated successfully.');

        return response()->json(['message' => $success], Response::HTTP_CREATED);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrfail($id);

        $role->delete();

        $success = $role->name . __(' has been successfully removed');

        return response()->json(['message' => $success], Response::HTTP_OK);
    }
}
