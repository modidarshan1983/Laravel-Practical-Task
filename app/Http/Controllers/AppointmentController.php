<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Healthcare;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class AppointmentController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized user'], 400);
        }
        $appointments = $user->appointments()->with('user', 'healthCare')->get();
       
    
        // Now, map over the appointments and replace user and healthcare IDs with their names
            $appointments = $appointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'user_name' => $appointment->user->name ?? null,
                    'healthcare_name' =>$this->gethealthcare($appointment->healthcare_id), 
                    'appointment_start_time' => $appointment->appointment_start_time,         
                    'appointment_end_time' => $appointment->appointment_end_time,         
                    'status' => $appointment->appointment_end_time,         
                ];
            });
            
            return response()->json($appointments);
    }

    public function book(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'healthcare_id' => 'required|exists:healthcares,id',
            'appointment_start_time' => 'required|date|after_or_equal:today',
            'appointment_end_time' => 'required|date|after:appointment_start_time',
        ]);

        $startDate = Carbon::createFromFormat('d-m-Y H:i:s', $request->input('appointment_start_time'))->format('Y-m-d H:i:s');
        $endDate = Carbon::createFromFormat('d-m-Y H:i:s', $request->input('appointment_end_time'))->format('Y-m-d H:i:s');
       
        // Check for availability
        $isAvailable = $this->isAppointmentAvailable(
            $request->input('healthcare_id'),
            $startDate,
            $endDate
        );
       
        if (!$isAvailable) {
            return response()->json(['message' => 'Appointment slot not available'], 400);
        }

        // Create appointment
        $appointment = Appointment::create([
            'user_id' => $request->input('user_id'),
            'healthcare_id' => $request->input('healthcare_id'),
            'appointment_start_time' => $startDate,
            'appointment_end_time' => $endDate,
        ]);

        return response()->json($appointment, 201);
    }

    private function isAppointmentAvailable($healthcareProfessionalId, $startTime, $endTime)
    {
        // Check if there are any overlapping appointments for the healthcare professional
        $existingAppointments = Appointment::where('healthcare_id', $healthcareProfessionalId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('appointment_start_time', [$startTime, $endTime])
                    ->orWhereBetween('appointment_end_time', [$startTime, $endTime]);
            })
            ->count();

        return $existingAppointments === 0;
    }

    public function cancel(Appointment $appointment)
    {
        // Check if cancellation is allowed (e.g., not within 24 hours of appointment time)
        $user = Auth::user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized user'], 400);
        }
        $cancellationTime = Carbon::now()->addHours(24);
        $appointmentTime = Carbon::parse($appointment->appointment_start_time);

        if ($cancellationTime->gte($appointmentTime)) {
            return response()->json(['message' => 'Cancellation not allowed within 24 hours of appointment time'], 400);
        }
        if ($appointment->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Update appointment status to "cancelled"
        $appointment->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Appointment cancelled successfully']);
    }

    public function complete(Appointment $appointment)
    {
        // Check if cancellation is allowed (e.g., not within 24 hours of appointment time)
       
        $cancellationTime = Carbon::now()->addHours(24);
        $appointmentTime = Carbon::parse($appointment->appointment_start_time);

        if ($cancellationTime->gte($appointmentTime)) {
            return response()->json(['message' => 'Completed not allowed within 24 hours of appointment time'], 400);
        }
        
        // Update appointment status to "cancelled"
        $appointment->update(['status' => 'completed']);

        return response()->json(['message' => 'Appointment completed successfully']);
    }
    public function gethealthcare($id){
        $healthCareName = Healthcare::where('id', $id)->select('name')->get();
        if($healthCareName){
            return $healthCareName[0]->name;
        }else{
            return null;
        }
    }
}
