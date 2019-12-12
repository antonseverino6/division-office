<?php

namespace App\Http\Controllers\API;

use App\EmployeePersonalDetail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('representative')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'admin' => 'required',
            'password' => ['required', 'string', 'min:8','confirmed'],
            'representative_id' => 'required',
            'password_confirmation' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'admin' => $request->admin,
            'registered_by' => auth('api')->user()->id,
            'representative_id' => $request->representative_id,
            'password' => Hash::make($request['password']),
        ]);
        
        if ($user) {
            $user_details = ['password' => $request['password'], 'admin' => $request['admin']];
            Mail::to($request['email'])->send(new NewUserMail($user_details));
            return $user;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function userProfile() {
        return EmployeePersonalDetail::with('representative')->where('user_id',auth('api')->user()->id)
                        ->rightJoin('employee_employment_details','employee_personal_details.id','=', 'employee_employment_details.employee_personal_detail_id')
                        ->select('*','employee_employment_details.id AS employment_details_id', 'employee_personal_details.id AS id')
                        ->get();
    }

    public function getUser() 
    {
        return json_encode(auth('api')->user()->id);
    }

    public function hasRecord() 
    {
        $record = EmployeePersonalDetail::where('user_id', auth('api')->user()->id)->exists();
        return json_encode($record);
        // return ['message' => $hasRecord];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id ],
            'admin' => 'required',
            'password' => ['sometimes', 'string', 'min:8','confirmed'],
            'representative_id' => 'required',
            'password_confirmation' => 'sometimes',
        ]);
        // $request->except($request->password_confirmation);
        // $user->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'admin' => $request->admin,
        //     'registered_by' => auth('api')->user()->id,
        //     'representative_id' => $request->representative_id,
        // ]);

            $request->merge(['registered_by' => auth('api')->user()->id]);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request->password)]);
        }
        
        $user->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return ['message' => 'deleted successfully'];
    }
}
