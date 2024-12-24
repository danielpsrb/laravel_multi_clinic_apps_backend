<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    //get data user users by role doctor with clinic and specialization
    public function index()
    {
        $doctors = User::where('role', 'doctor')
            ->with('clinic', 'specialization')  // Eager loading relasi
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors
        ], 200);
    }

    //store data user doctor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
            'clinic_id' => 'required',
            'specialist_id' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $doctor  = User::create($data);

        //upload photo doctor
        if ($request->hasFile('photo')) {
            $photoUser = $request->file('photo');
            $photoName = $photoUser->hashName();
            $photoUser->storeAs('public/photos/doctor', $photoName);
            $doctor->photo = $photoName;
            $doctor->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctor
        ], 201);
    }

    //update data doctor
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'clinic_id' => 'required',
            'specialist_id' => 'required',
        ]);

        $doctor = User::find($id);
        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor not found'
            ], 404);
        }

        $data = $request->all();
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $doctor->update($data);

        //upload photo doctor
        if ($request->hasFile('photo')) {
            $photoUser = $request->file('photo');
            $photoName = $photoUser->hashName();
            $photoUser->storeAs('public/photos/doctor', $photoName);
            $doctor->photo = $photoName;
            $doctor->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctor
        ], 200);
    }

    //destroy data
    public function destroy($id)
    {
        $doctor = User::find($id);
        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor not found'
            ], 404);
        }

        $doctor->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor deleted'
        ], 200);
    }

    //getDoctorActive
    public function getDoctorActive()
    {
        $doctors = User::where('role', 'doctor')
            ->where('status', 'active')
            ->with('clinic', 'specialization')  // Eager loading relasi
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors
        ], 200);
    }

    //get search doctor by name and category specialist
    public function searchDoctor(Request $request)
    {
        $name = $request->name;
        $specialist_id = $request->specialist_id;

        $doctors = User::where('role', 'doctor')
            ->where('name', 'like', '%' . $name . '%')
            ->where('specialist_id', $specialist_id)
            ->with('clinic', 'specialization')  // Eager loading relasi
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors
        ], 200);
    }

    //get data doctor by id
    public function getDataDoctorById($id)
    {
        $doctor = User::find($id);
        if (!$doctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $doctor
        ], 200);
    }

    //get data doctor by clinic
    public function getDoctorByClinic($clinic_id)
    {
        $doctors = User::where('role', 'doctor')
            ->where('clinic_id', $clinic_id)
            ->with('clinic', 'specialization')  // Eager loading relasi
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors
        ], 200);
    }

    //get data doctor by specialist
    public function getDoctorBySpecialist($specialist_id)
    {
        $doctors = User::where('role', 'doctor')
            ->where('specialist_id', $specialist_id)
            ->with('clinic', 'specialization')  // Eager loading relasi
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $doctors
        ], 200);
    }
}
