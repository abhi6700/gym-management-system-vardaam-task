<?php

namespace App\Http\Controllers\tenant;

use App\Http\Controllers\Controller;
use App\Models\GymMember;
use App\Models\GymMemberHealth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class GymMemberController extends Controller
{

    private $user_id;
    public function __construct()
    {
        $this->user_id = auth()->user()->id;
        if(auth()->user()->role == "admin") {
            abort(401);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('tenant/gym-members/index', [
            'gym_members' => GymMember::with(['gym_member_health' => function ($query) {
                $query->latest()->first();
            }])
            ->where('gym_id', $this->user_id)
            ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('tenant/gym-members/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:gym_members,email'],
                'dob' => ['required'],
            ]);
            
            GymMember::create([
                'name' => ucfirst($request->name),
                'email' => $request->email,
                'dob' => $request->dob,
                'gym_id' => $this->user_id
            ]);
            
            return redirect()->route('gym_members.index');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return Inertia::render('tenant/gym-members/create', [
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
        $gym_member = GymMember::find($id);
        if($gym_member->gym_id != $this->user_id){
            abort(401);
        }
        return Inertia::render('tenant/gym-members/update', [
            'gym_member' => $gym_member
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $gym_member = GymMember::find($id);
            if($gym_member->gym_id != $this->user_id){
                abort(401);
            }
            $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255',
                            Rule::unique('gym_members', 'email')->ignore($id),      
                ],
                'dob' => ['required'],
            ]);

            $gym_member->update([
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
            ]);
            
            return redirect()->route('gym_members.index');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return Inertia::render('tenant/gym-members/update', [
                'error' => 'Something went wrong!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    ///////////////////////////////// Health /////////////////////////////////
    public function add_health(string $id){
        $gym_member = GymMember::find($id);
        if($gym_member->gym_id != $this->user_id){
            abort(401);
        }
        return Inertia::render('tenant/gym-members/health/create', [
            'id' => $id
        ]);
    }
    
    public function store_health($id, Request $request){
        try {
            $gym_member = GymMember::find($id);
            if($gym_member->gym_id != $this->user_id){
                abort(401);
            }
            $request->validate([
                'height' => ['required', 'numeric'],
                'weight' => ['required', 'numeric'],
            ]);

            // Bmi calculation
            $height = $request->height;
            $weight = $request->weight;
            $heightMeters  = $height * 0.0254;
            $bmi = $weight / ($heightMeters * $heightMeters);
            //
            
            $date = Carbon::now();
            
            GymMemberHealth::create([
                'height' => $height,
                'weight' => $weight,
                'bmi' => $bmi,
                'gym_member_id' => $id,
                'date' => $date->toDateString(),
            ]);
            
            return redirect()->route('gym_members.index');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            return Inertia::render('tenant/gym-members/health/create', [
                'error' => 'Something went wrong!'
            ]);
        }
    }
}
