<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Subject;
use App\Message;
use App\File;

class SubjectController extends Controller
{
    public function get(Request $request, $subjectId)
    {
        $params['subject_id'] = $subjectId;

        $validator = Validator::make($params, [
            'subject_id' => 'required|integer|exists:subjects,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $subject = Subject::find($params['subject_id']);
        $subject->messages;
        if ($request->user()->userable_type === 'student') {
            $subject->teachers;
        } elseif ($request->user()->userable_type === 'teacher') {
            $subject->groups;
        }

        return response()->json([
            'status' => true,
            'subject' => $subject
        ], 200);
    }

    public function addMessage(Request $request, $subjectId)
    {
        $params = $request->only('message');
        $params['created_at'] = date('Y-m-d H:i:s');
        $params['subject_id'] = $subjectId;

        $validator = Validator::make($params, [
            'message' => 'required|min:3',
            'subject_id' => 'required|integer|exists:subjects,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $message = new Message([
            'message' => $params['message'],
            'created_at' => $params['created_at'],
            'subject_id' => $params['subject_id']
        ]);
        $message->save();

        return response()->json([
            'status' => true,
            'message' => 'Message was successfully added'
        ], 200);
    }

    public function deleteMessage(Request $request, $subjectId, $messageId)
    {
        $params['subject_id'] = $subjectId;
        $params['message_id'] = $messageId;

        $validator = Validator::make($params, [
            'subject_id' => 'required|integer|exists:subjects,id',
            'message_id' => 'required|integer|exists:messages,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $message = Message::find($params['message_id']);

        if ($message->subject->id !== (int) $params['subject_id']) {
            return response()->json([
                'status' => false,
                'message' => 'Message does not belong to this subject'
            ], 404);
        } else {
            $message->delete();

            return response()->json([
                'status' => true,
                'message' => 'Message was successfully deleted'
            ], 200);
        }
    }

    public function getFiles(Request $request, $subjectId)
    {
        $params['subject_id'] = $subjectId;

        $validator = Validator::make($params, [
            'subject_id' => 'required|integer|exists:subjects,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $subject = Subject::find($params['subject_id']);

        return response()->json([
            'status' => true,
            'files' => $subject->files
        ], 200);
    }

    public function addFile(Request $request, $subjectId)
    {
        $params['file'] = $request->file('file');
        $params['subject_id'] = $subjectId;

        $validator = Validator::make($params, [
            'file' => 'required|file|max:102400',
            'subject_id' => 'required|integer|exists:subjects,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $file = new File([
            'subject_id' => $params['subject_id'],
            'name' => $params['file']->getClientOriginalName(),
            'file' => $params['file']->store('')
        ]);
        $file->save();

        return response()->json([
            'status' => true,
            'message' => 'File was successfully added'
        ], 200);
    }

    public function editFile(Request $request, $subjectId, $fileId)
    {
        $params = $request->only('new_name');
        $params['subject_id'] = $subjectId;
        $params['file_id'] = $fileId;

        $validator = Validator::make($params, [
            'new_name' => 'required|string|max:255|unique:files,name',
            'subject_id' => 'required|integer|exists:subjects,id',
            'file_id' => 'required|integer|exists:files,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $file = File::find($params['file_id']);

        if ($file->subject->id !== (int) $params['subject_id']) {
            return response()->json([
                'status' => false,
                'message' => 'File does not belong to this subject'
            ], 404);
        } else {
            $file->setName($params['new_name']);

            return response()->json([
                'status' => true,
                'message' => 'File was successfully edited'
            ], 200);
        }
    }

    public function deleteFile(Request $request, $subjectId, $fileId)
    {
        $params['subject_id'] = $subjectId;
        $params['file_id'] = $fileId;

        $validator = Validator::make($params, [
            'subject_id' => 'required|integer|exists:subjects,id',
            'file_id' => 'required|integer|exists:files,id'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'message' => $errors->all()
            ], 400);
        }

        $file = File::find($params['file_id']);
        
        if ($file->subject->id !== (int) $params['subject_id']) {
            return response()->json([
                'status' => false,
                'message' => 'File does not belong to this subject'
            ], 404);
        } else {
            $file->delete();

            return response()->json([
                'status' => true,
                'message' => 'File was successfully deleted'
            ], 200);
        }
    }
}
