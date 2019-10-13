<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\RolesRequest;
use App\Http\Requests\RolesUpdateRequest;
use Caffeinated\Shinobi\Models\Role;
use App\User;
use Validator;

class RolesControllers extends Controller
{
	public function __construct (){
		$this->successStatus = 200;
		$this->role = new Role();
		$this->allRoles = $this->role::all();
        $this->user = new user();
	}

	//get all roles
	public function show (){
		if (count($this->allRoles) >= 1){
			return response()->json(['success' => $this->allRoles], $this->successStatus);
		} else {
            return response()->json(['success' => 'No existe ningun rol de usuario'], $this->successStatus);
		}
	}

    //create roles
    public function store (RolesRequest $request){
    	$this->role->name = $request->name;
	    $this->role->slug = $request->slug;
	    $this->role->description = $request->description;
	    $this->role->save();
	    return response()->json(['success' => 'Se ha guardado el rol de usuario correctamente.'], $this->successStatus);	
    }

    //filter roles by id
    public function filter ($id){
    	$this->filterRole = $this->role::find($id);
    	//if filter role
    	if ($this->filterRole){
    		return response()->json(['success' => $this->filterRole], $this->successStatus);
    	} else {
    		return response()->json(['error' => 'No se ha encontrado ningun rol con la id: '.$id]);
    	}
    }

    //delete roles
    public function delete ($id){
    	$this->filterRole = $this->role::find($id);
    	//if filter role
    	if ($this->filterRole){
    		$this->filterRole->delete();
    		return response()->json(['success' => 'Se ha borrado el rol de usuario'], $this->successStatus);
    	} else {
    		return response()->json(['error' => 'No se ha encontrado ningun rol con la id: '.$id]);
    	}
    }

    //update roles
    public function update ($id, RolesUpdateRequest $request){
    	$this->filterRole = $this->role::find($id);
    	//if filter role	
    	if ($this->filterRole){
    		$this->filterRole->update([
	    		'name' => $request->name,
	    		'slug' => $request->slug,
	    		'description' => $request->description
	    	]);
	    	return response()->json(['success' => 'Se ha modificado el rol de usuario'], $this->successStatus);
    	} else {
    		return response()->json(['error' => 'No se ha encontrado ningun rol con la id: '.$id]);
    	}
    }

    //assign roles
    public function assingRoles ($user_id, $role_id){
        $this->filterUser = $this->user::find($user_id);
        $this->filterRole = $this->role::find($role_id);
        if ($this->filterUser and $this->filterRole){
            $this->filterUser->assignRoles($this->filterRole);
            return response()->json(['success' => 'Se ha asignado el rol al usuario'], $this->successStatus);
        } else {
            return response()->json(['error' => 'No se ha encontrado ningun usuario con la id: '.$user_id.' o algun rol para la id: '.$role_id]);
        }
    }

    //show user roles
    public function returnUserRoles ($user_id){
        //return response()->json($user_id);
        $this->filterUser = $this->user::find($user_id);
        if ($this->filterUser){
            $this->userRole = $this->filterUser->roles;
            return response()->json(['success' => $this->userRole], $this->successStatus);
        } else {
            return response()->json(['error' => 'No se ha encontrado ningun usuario con la id: '.$user_id], $this->successStatus);
        }
    }

    //revoke roles by id
    public function revokeById ($user_id, $role_id){
        //filter role by id
        $this->filterRole = $this->role::find($role_id);
        if ($this->filterRole){
            //filter user to revoke role
            $this->filterUser = $this->user::find($user_id);
            if ($this->filterUser){
                $this->filterUser->removeRoles($this->filterRole);
                return response()->json(['success' => 'Se ha quitado el rol al usuario'], $this->successStatus);
            } else {
                return response()->json(['error' => 'No se ha encontrado ningun usuario con la id: '.$user_id], $this->successStatus);
            }

        } else {
            return response()->json(['error' => 'No se ha encontrado ningun rol con la id: '.$role_id], $this->successStatus);
        }
    }

    //remove roles by slug
    public function revokeBySlug ($user_id, $slug){
        //return response()->json($slug);
        $this->filterUser = $this->user::find($user_id);
        if ($this->filterUser->removeRoles($slug)){
            return response()->json(['success' => 'Se ha quitado el rol al usuario'], $this->successStatus);
        }else{
            return response()->json(['error' => 'El usuario No cuenta con ningun rol con la slug: '.$slug], $this->successStatus);
        }
    }

}
