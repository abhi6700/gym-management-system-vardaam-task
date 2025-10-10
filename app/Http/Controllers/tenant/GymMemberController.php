<?php

namespace App\Http\Controllers\tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGymMemberHealthRequest;
use App\Http\Requests\StoreGymMemberRequest;
use App\Http\Requests\UpdateGymMemberRequest;
use App\Models\GymMember;
use App\Models\GymMemberHealth;
use App\Repositories\gym_member\GymMemberRepositoryInterface;
use App\Repositories\gym_member\Health\GymMemberHealthRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class GymMemberController extends Controller
{

    private $user_id;
    public function __construct(public GymMemberRepositoryInterface $gym_member, public GymMemberHealthRepositoryInterface $gym_member_health)
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
    public function store(StoreGymMemberRequest $request)
    {
        try {
            $data = [
                'name' => ucfirst($request->name),
                'email' => $request->email,
                'dob' => $request->dob,
                'gym_id' => $this->user_id
            ];

            $this->gym_member->store($data);
            
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
        $gym_member = $this->gym_member->find($id);
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
    public function update(UpdateGymMemberRequest $request, string $id)
    {
        try {
            $gym_member = $this->gym_member->find($id);
            if($gym_member->gym_id != $this->user_id){
                abort(401);
            }

            $gym_member = [
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
            ];

            $this->gym_member->update($id, $gym_member);
            
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
        $gym_member = $this->gym_member->find($id);
        if($gym_member->gym_id != $this->user_id){
            abort(401);
        }
        return Inertia::render('tenant/gym-members/health/create', [
            'id' => $id
        ]);
    }
    
    public function store_health($id, StoreGymMemberHealthRequest $request){
        try {
            $gym_member = $this->gym_member->find($id);
            if($gym_member->gym_id != $this->user_id){
                abort(401);
            }

            // Bmi calculation
            $height = $request->height;
            $weight = $request->weight;
            $heightMeters  = $height * 0.0254;
            $bmi = $weight / ($heightMeters * $heightMeters);
            //
            
            $date = Carbon::now();

            $data = [
                'height' => $height,
                'weight' => $weight,
                'bmi' => $bmi,
                'gym_member_id' => $id,
                'date' => $date->toDateString(),
            ];
            $this->gym_member_health->store($data);
            
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
