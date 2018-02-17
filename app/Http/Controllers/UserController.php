<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getMyInfo(Request $request)
    {
        $user = $request->user();
        $user->userable;

        if ($user->userable_type === 'student') {
            $user->userable->group;
        }

        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }

    public function editEmail(Request $request)
    {
        $params = $request->only('email');

        $validator = Validator::make($params, [
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $user = $request->user();

        $user->setEmail($params['email']);       

        return response()->json([
            'status' => true,
            'message' => 'Email was successfully updated'
        ], 200);
    }

    public function editPassword(Request $request)
    {
        $params = $request->only('old_password', 'password', 'password_confirmation');

        $validator = Validator::make($params, [
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'same:password'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $user = $request->user();

        if (Hash::check($params['old_password'], $user->password)) {
            $user->setPassword(Hash::make($params['password']));

            return response()->json([
                'status' => true,
                'message' => 'Password was successfully updated'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Old password is incorrect'
            ], 403);
        }
    }

    public function getSchedule(Request $request, $day)
    {
        $user = $request->user();

        $now = Carbon::now();
        $semesterStart = Carbon::createFromDate(null, 9, 1);

        if ($now->lt($semesterStart)) {
            $semesterStart->addWeeks(15 + 2 + 8);
            $semesterStart->subYear();
        }

        if ($semesterStart->dayOfWeek !== 1) {
            $semesterStart->addDays(7 - $semesterStart->dayOfWeek + 1);
        }

        $weekNumber = $now->diffInWeeks($semesterStart) + 1;

        $isOdd = ($weekNumber % 2) ? 1 : 0;

        $schedule = $user->getSchedule($day, $isOdd);

        return response()->json([
            'status' => true,
            'schedule' => $schedule
        ], 200);
    }

    public function getSubjects(Request $request)
    {
        $user = $request->user();

        $subjects = $user->userable->getSubjects();

        return response()->json([
            'status' => true,
            'subjects' => $subjects
        ], 200);
    }
}
