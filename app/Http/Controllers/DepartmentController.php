<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
         * path="/deparments",
         * summary="List Departments",
         * description="List all departments",
         * operationId="departmentList",
         * tags={"department"},
         * @OA\Response(
         *    response=200,
         *    description="Successful response",
         *    @OA\JsonContent(
         *       @OA\Property(property="message", type="object", example="[{'id':1,'name':'Department 1','created_at':'2021-09-27T13:14:03.000000Z','updated_at':'2021-09-27T13:14:03.000000Z'}]"),
         *       @OA\Property(property="status", type="boolean", example="true"))
         *     )
         * )
         */

        return response(
            ['message' => Department::all(), 'status' => true], 200
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
        //
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
