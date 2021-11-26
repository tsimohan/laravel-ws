<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Events\CreateStudentEvent;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        /**
         * @OA\Get(
         * path="/students",
         * summary="List Students",
         * description="List all students with departments",
         * operationId="studentList",
         * tags={"student"},
         * @OA\Response(
         *    response=200,
         *    description="Successful response",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="object", example="[{'id':1,'name':'Student 1','dept_id':1,'created_at':'2021-09-27T13:14:26.000000Z','updated_at':'2021-09-27T13:14:26.000000Z','department':{'id':1,'name':'Department 1','created_at':'2021-09-27T13:14:03.000000Z','updated_at':'2021-09-27T13:14:03.000000Z'}}]"),
         *       @OA\Property(property="status", type="boolean", example="true"))
         *     )
         * )
         */
        return response(
            ['message' => Student::with(['department'])->get(), 'status' => true], 200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        /**
         * @OA\Post(
         * path="/students",
         * summary="Create Students",
         * description="Create a new student with a particular department",
         * operationId="studentCreate",
         * tags={"student"},
         * @OA\RequestBody(
         *      description= "Provide student details",
         *      required=true,
         *      @OA\JsonContent(
         *          type="object",
         *          @OA\Property(property="name", type="string"),
         *          @OA\Property(property="department", type="integer")
         *      )
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
         *       @OA\Property(property="data", type="object", example="[{'id':21,'name':'Student 7','dept_id':2,'created_at':'2021-09-28T05:35:31.000000Z','updated_at':'2021-09-28T05:35:31.000000Z','department':{'id':2,'name':'Department 2','created_at':'2021-09-27T13:14:03.000000Z','updated_at':'2021-09-27T13:14:03.000000Z'}}]"),
         *       @OA\Property(property="message", type="string", example="Student has been created"),
         *       @OA\Property(property="status", type="boolean", example="true"))
         *     )
         * )
         * 
         * @return JsonResponse
         * 
         */

        $validated = $request->validate([
            'name' => 'required|min:3|unique:students',
            'department' => 'required',
        ]);
        if($validated) {
            $student = Student::create([
                'name' => $request->name,
                'dept_id' => $request->department,
            ]);
            $student->save();
            $data = [
                "data" => Student::where('id', '=', $student->id)->with(['department'])->get(),
                "status" => true,
                "message" => "Student has been created"
            ];
            event(new CreateStudentEvent($data));
            return(response($data, 200));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
