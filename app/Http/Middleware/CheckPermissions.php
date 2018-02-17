<?php

namespace App\Http\Middleware;

use Closure;
use App\Subject;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $subject = Subject::find($request->subjectId);

        foreach ($subject->teachers as $teacher) {
            if ($teacher->user && $teacher->user->id === $user->id) {
                return $next($request);
            } 
        }

        return response()->json([
            'status' => false,
            'message' => 'Permission denied'
        ], 403);
    }
}
