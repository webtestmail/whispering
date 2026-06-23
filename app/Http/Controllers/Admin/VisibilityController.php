<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class VisibilityController extends Controller
{
    function index(Request $request)
    {
                // dd($request->all());    
        $request->validate([
            'model' => 'required|string',
            'visibility' => 'required|string',
            'encrypted_id' => 'required|string',
        ]);  


        $modelClass = 'App\\Models\\Admin\\' . Crypt::decrypt($request->model);
        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => "Can't find the table!"]);
        } else {
            $id = Crypt::decrypt($request->encrypted_id);
            $model = $modelClass::find($id);
            if ($model) {
                $model->visibility = $request->visibility;
                if ($model->save()) {
                    return response()->json(['status' => 'done', 'message' => "Operation of Visibility is done."]);
                } else {
                    return response()->json(['status' => 'error', 'message' => "Can't operate the Visibility operation!"]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => "Can't find the data!"]);
            }
        }
    }

    function headerFooterIndex(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'header_footer_visibility' => 'required|string',
            'encrypted_id' => 'required|string',
        ]);

        $modelClass = 'App\\Models\\Admin\\' . Crypt::decrypt($request->model);
        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => "Can't find the table!"]);
        } else {
            $id = Crypt::decrypt($request->encrypted_id);
            $model = $modelClass::find($id);
            if ($model) {
                $model->header_footer_visibility = $request->header_footer_visibility;
                if ($model->save()) {
                    return response()->json(['status' => 'done', 'message' => "Operation of Visibility is done."]);
                } else {
                    return response()->json(['status' => 'error', 'message' => "Can't operate the Visibility operation!"]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => "Can't find the data!"]);
            }
        }
    }
}
