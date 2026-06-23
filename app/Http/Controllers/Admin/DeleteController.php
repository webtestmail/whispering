<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DeleteController extends Controller
{
    function index(Request $request)
    {
        

        $request->validate([
            'model' => 'required|string',
            'encrypted_id' => 'required|string',
        ]);

        $modelClass = 'App\\Models\\Admin\\' . Crypt::decrypt($request->model);
        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => "Can't find the table!"]);
        } else {
            $id = Crypt::decrypt($request->encrypted_id);
            $model = $modelClass::find($id);
            if ($model) {
                if ($model->delete()) {
                    return response()->json(['status' => 'done', 'title' => "Delete operation is done.", 'message' => "Your file has been deleted."]);
                } else {
                    return response()->json(['status' => 'error', 'title' => "Can't operate the Delete operation!", 'message' => "Your data is safe :)"]);
                }
            } else {
                return response()->json(['status' => 'error', 'title' => "Data Not Found!", 'message' => "Can't find the data!"]);
            }
        }
    }
}
