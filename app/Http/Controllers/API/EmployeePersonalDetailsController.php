<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\EmployeePersonalDetail;
use App\EmployeeEmploymentDetail;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Employees\AddEmployeeRequest;

class EmployeePersonalDetailsController extends Controller
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
        //
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
    public function store(AddEmployeeRequest $request)
    {

        $emp = EmployeePersonalDetail::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'suffix' => $request->suffix,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'civil_status_id' => $request->civil_status_id,
            'per_address' => $request->per_address,
            'contact_num' => $request->contact_num,
            'email' => $request->email,
            'created_by' => auth('api')->user()->id,
            'representative_id' => auth('api')->user()->representative_id,
        ]);

        if ($emp) {
            EmployeeEmploymentDetail::create([
                'employee_personal_detail_id' => $emp->id,
                'employee_id' => $request->employee_id,
                'tin_no' => $request->tin_no,
                'role_type' => $request->role_type,
                'employment_status_id' => $request->employment_status_id,
                'job_code' => $request->job_code,
                'date_join' => $request->date_join,
                'date_appoint' => $request->date_appoint,
                'work_shift' => $request->work_shift,
                'biometric' => $request->biometric,
                'item_num' => $request->item_num,
            ]);

            $jayson = ['emp_id' => $emp->id];

            if ($request->image) {
                $imageData = $request->image;
                $name = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                // $request->merge(['image' => $name]);
                array_push($jayson,['image' => $name]);
                // $name->store('profile','public');
                Image::make($request->image)->save(public_path('img/profile/').$name);
                $emp->update(['image' => $name]);
                // $image->save();
                // store('profile','public')
            }

            return $jayson;

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validation($request)
    {
        return $this->validate($request, [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'civil_status_id' => 'required',
            'gender' => 'required',
            'per_address' => 'required',
            'contact_num' => 'required',
            'email' => 'required|unique:employee_personal_details',
            'employee_id' => 'required|unique:employee_employment_details',
            'tin_no' => 'required|unique:employee_employment_details',
            'role_type' => 'required',
            'employment_status_id' => 'required',
            'job_code' => 'required',
            'date_join' => 'required',
            'date_appoint' => 'required',
            'work_shift' => 'required',
            'item_num' => 'required',
        ]);
    }
}
