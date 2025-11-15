<?php

namespace Modules\VirtualClass\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadMedia;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\VirtualClass\Entities\ClassRecord;

class MeetingRecordController extends Controller
{
    use UploadMedia;

    public function index($class_id, $meeting_id)
    {
        $records = ClassRecord::where('class_id', $class_id)->where('meeting_id', $meeting_id)->get();
        return view('virtualclass::record._list_modal', compact('records'));
    }

    public function store(Request $request, $class_id, $meeting_id){
        $rules = [
            'title' => 'required',
            'file' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        $record = ClassRecord::create([
            'class_id' => $class_id,
            'meeting_id' => $meeting_id,
            'title' => $request->title,
        ]);
        $record->url =     $this->generateLink($request->file, $record->id, get_class($record), 'file');
        $record->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return back();
    }

    public function create($class_id, $meeting_id)
    {
        $url =route('virtual-class.records.create', [$class_id, $meeting_id]);
        return view('virtualclass::record._create_modal', compact('url'));
    }

}
