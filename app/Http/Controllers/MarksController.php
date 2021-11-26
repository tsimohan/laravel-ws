<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Student;

class MarksController extends BaseController {
    public function marks($dept_id) {
        /**
         * @OA\Get(
         * path="/marks/{dept_id}",
         * summary="List Marks",
         * description="Get each student Mark List for a particular department",
         * operationId="markList",
         * tags={"mark"},
         * @OA\Parameter(
         *    name="dept_id",
         *    description="Department Id",
         *    required=true,
         *    in="path",
         *    @OA\Schema(
         *        type="integer"
         *    )
         * ),
         * @OA\Response(
         *    response=422,
         *    description="Exception Caught",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="string", example="Unprocessible Entity"),
         *       @OA\Property(property="status", type="boolean", example="false")
         *     )
         * ),
         * @OA\Response(
         *    response=200,
         *    description="Successful response",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="object", example="[{'id':1,'name':'Student1','dept_id':1,'created_at':'2021-09-27T13:14:26.000000Z','updated_at':'2021-09-27T13:14:26.000000Z','marks':[{'id':1,'stu_id':1,'sub_id':1,'sem_id':1,'mark':'50','total':'75','created_at':'2021-09-27T13:15:28.000000Z','updated_at':'2021-09-27T13:15:28.000000Z'},{'id':13,'stu_id':1,'sub_id':1,'sem_id':2,'mark':'53','total':'75','created_at':'2021-09-27T14:12:20.000000Z','updated_at':'2021-09-27T14:12:20.000000Z'},{'id':25,'stu_id':1,'sub_id':1,'sem_id':3,'mark':'53','total':'75','created_at':'2021-09-27T14:12:20.000000Z','updated_at':'2021-09-27T14:12:20.000000Z'}]}]"),
         *       @OA\Property(property="status", type="boolean", example="true"))
         *     )
         * )
         */

        $err_message = [
            'message' => 'Unprocessible Entity',
            'status' => false
        ];
        
        $stumarks = Student::where('dept_id', '=', $dept_id)->with(['marks.semester', 'marks.subject', 'marks.student', 'department'])->get();
        $data = [];

        foreach($stumarks as $marks) {
            foreach($marks->marks as $mark) {
                $data[$mark->stu_id]['student'] = $mark->student;
                $data[$mark->stu_id]['marks'][$mark->sem_id]['semester'] = $mark->semester;
                $data[$mark->stu_id]['marks'][$mark->sem_id]['data'][$mark->sub_id] = $mark;
            }
        }
        
        $data = array_values($data);

        // return response($data);

        if(count($stumarks) > 0)
            return response(['message' => $data, 'status' => true], 200);
        else
            return response($err_message, 422);
    }
}