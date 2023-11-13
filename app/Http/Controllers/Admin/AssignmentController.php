<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Raffle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $users = User::all();
        $assignments =  Assignment::with('firstUser', 'secondUser', 'thirdUser')->paginate(12);
        return view('intranet.pages.assignment.index', compact(['assignments', 'users']));
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $assignment = new Assignment();
            $assignment->user_id_1 = $request->input('user_id_1');
            $assignment->user_id_2 = $request->input('user_id_2');
            $assignment->user_id_3 = $request->input('user_id_3');
            $assignment->start = $request->input('start');
            $assignment->end = $request->input('end');
            $assignment->codes = $request->input('codes');
            $assignment->type = $request->input('types', 'rango');

            $isVisibleInWeb=null;
            if($request->input('is_visible_in_web')=="si" || $request->input('is_visible_in_web')=="no"){
                $isVisibleInWeb = $request->input('is_visible_in_web')=="si"?1:0;
            }
            
            $assignment->is_visible_in_web = $isVisibleInWeb;
            $assignment->save();

            if(!$assignment->codes && (!$assignment->start || !$assignment->end)){
                return back()->with('error', 'Completa el rango de numeros o coloca los códigos separados por comas');
            }


            if (!$assignment->start || !$assignment->end) {
                $numbers = explode(',', $assignment->codes);

                if(!count($numbers)){
                    return back()->with('error', 'No se ha podido asignar los números, por favor intente nuevamente');
                }

                $numbersClean = [];
                foreach ($numbers as $number) {
                    $numbersClean[] = (int) trim($number . "");
                }

                if (!count($numbersClean)) {
                    return back()->with('error', 'No se ha podido asignar los números, por favor intente nuevamente');
                }

                $columnsUpdate= [
                    'user_id_1' => $assignment->user_id_1,
                    'user_id_2' => $assignment->user_id_2,
                    'user_id_3' => $assignment->user_id_3
                ];

                if($isVisibleInWeb!=null){
                    $columnsUpdate['is_visible_in_web'] = $isVisibleInWeb;
                }

                Raffle::whereIn('number', $numbersClean)->update($columnsUpdate);
                $assignment->type = 'codigos';
                $assignment->save();



            } else {
                $columnsUpdate= [
                    'user_id_1' => $assignment->user_id_1,
                    'user_id_2' => $assignment->user_id_2,
                    'user_id_3' => $assignment->user_id_3
                ];

                if($isVisibleInWeb!=null){
                    $columnsUpdate['is_visible_in_web'] = $isVisibleInWeb;
                }

                $raffles = Raffle::whereBetween('number', [$assignment->start, $assignment->end])->update(
                    $columnsUpdate
                );
                $assignment->type = 'rango';
            }

            DB::commit();

            return back()->with('success', 'Se ha asignado los números correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'No se ha podido asignar los números, por favor intente nuevamente. ' . $e->getMessage());
        }
    }
}
