<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentDetail;
use App\Models\Raffle;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(){
        $users = User::get();
        $assignments =  Assignment::get();
        return view('intranet.pages.assignment.index', compact(['assignments', 'users']));
    }

    public function store(Request $request){
        $assignment = Assignment::create([
            'option1_id' => $request->option1_id,
            'option2_id' => $request->option2_id,
            'option3_id' => $request->option3_id,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        for ($i=$request->start; $i <= $request->end ; $i++) {
            $raffle = Raffle::where('number', $i)->first();
            AssignmentDetail::create([
                'assignment_id' => $assignment->id,
                'option1_id' => $request->option1_id,
                'option2_id' => $request->option2_id,
                'option3_id' => $request->option3_id,
                'raffle_id' => $raffle->id
            ]);
        }

        return back();
    }

    public function detail($id){
        $details = AssignmentDetail::where('assignment_id', $id)->get();
        return view('intranet.pages.assignment.detail.index', compact(['details']));
    }
}
