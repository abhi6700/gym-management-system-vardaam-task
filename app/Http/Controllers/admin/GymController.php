<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGymRequest;
use App\Http\Requests\UpdateGymRequest;
use App\Repositories\gym\GymRepositoryInterface;
use App\Repositories\user\UserRepositoryInterface;
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
    public function __construct(public GymRepositoryInterface $gym, public UserRepositoryInterface $user)
    {
        $this->user_id = auth()->user()->id;
        if(auth()->user()->role == "tenant") {
            abort(401);
        }
    }

    public function index()
    {
        $gyms = $this->gym->all($this->user_id);
        return Inertia::render('admin/gym/index', [
            'gyms'=> $gyms,
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
    public function store(StoreGymRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'admin_id' => $this->user_id
            ];
            $this->gym->store($data);
            
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'tenant',
                'tenant_id' => 'tenant',
            ];

            $this->user->store($userData);

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
        $gym = $this->gym->find($id);
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
    public function update(UpdateGymRequest $request, string $id)
    {
        try {
            $gym = $this->gym->find($id);
            if($gym->admin_id != $this->user_id){
                abort(401);
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
            ];

            $this->gym->update($id, $data);

            // $userData = [
            //     'name' => $request->name,
            //     'email' => $request->email,
            // ];
            // $this->user->update($gym->admin_id, $userData);

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
        $gym = $this->gym->find($id);
        if($gym->admin_id != $this->user_id){
            abort(401);
        }
        $this->gym->destroy($id);
        return redirect()->route('gym.index');
    }
}
