<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $user_id;
    public function __construct()
    {
        $this->user_id = auth()->user()->id;
        if(auth()->user()->role == "tenant") {
            abort(401);
        }
    }

    public function index()
    {
        return Inertia::render('admin/gym/index', [
            'gyms'=> Gym::where('admin_id', $this->user_id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/gym/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:gyms,email'],
                'contact_no' => ['required', 'numeric'],
                'address' => ['required'],
                'password' => ['required', 'min:6'],
            ]);
            
            Gym::create([
                'name' => $request->name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'admin_id' => $this->user_id

            ]);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'tenant',
            ]);
            return redirect()->route('gym.index');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return Inertia::render('admin/gym/create', [
                'error' => 'Something went wrong!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gym = Gym::find($id);
        if($gym->admin_id != $this->user_id){
            abort(401);
        }
        return Inertia::render('admin/gym/update', [
            'gym' => $gym,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $gym = Gym::find($id);
            if($gym->admin_id != $this->user_id){
                abort(401);
            }
            $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required',
                        'email',
                        'max:255',
                        Rule::unique('gyms', 'email')->ignore($id),  
                ],
                'contact_no' => ['required', 'numeric'],
                'address' => ['required'],
            ]);
            
            $gym->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
            ]);
            return redirect()->route('gym.index');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return Inertia::render('admin/gym/update', [
                'error' => 'Something went wrong!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gym = Gym::find($id);
        if($gym->admin_id != $this->user_id){
            abort(401);
        }
        $gym->delete();
        return redirect()->route('gym.index');
    }
}
