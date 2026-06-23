<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StatusController extends Controller
{
    function index(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'model' => 'required|string',
            'encrypted_id' => 'required|string',
        ]);

        $modelClass = 'App\\Models\\Admin\\' . Crypt::decrypt($request->model);
        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => "Can't find the table!"]);
        }
        
        else {
            $id = Crypt::decrypt($request->encrypted_id);

            // dd($id);
            $model = $modelClass::find($id);
            if ($model) {
                if ($model->status == 'active') {
                    $model->status = 'deactive';
                } else {
                    $model->status = 'active';
                }
                if ($model->save()) {
                    return response()->json(['status' => 'done', 'message' => "Status change operation is done."]);
                } else {
                    return response()->json(['status' => 'error', 'message' => "Can't operate the Status operation!"]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => "Can't find the data!"]);
            }
        }
    }
}
