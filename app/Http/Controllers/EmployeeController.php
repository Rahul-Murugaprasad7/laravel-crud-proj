<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->paginate(2);
        return view('index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees,email|email',
            'phone' => 'required|numeric|unique:employees,phone',
            'joining_date' => 'required',
            'salary' => 'required'
        ],[
            'phone.unique' => 'Phone number already exist'
        ]);
        

        $data = $request->except('_token');

//Mass Assignment |

        Employee::create($data);


//Inserts single row |
        // $employee = new Employee;
        // $employee->name = $data['name'];
        // $employee->email = $data['email'];
        // $employee->joining_date = $data['joining_date'];
        // $employee->salary = $data['salary'];
        // $employee->phone = $data['phone'];
        // $employee->is_active = $data['is_active'];
        // $employee->save();  
        //dd('Inserted Successully');

//it helps to print all the values in the server
        //dd($request->all());

        return redirect()
        ->route('employee.index')
//used to print the successful message
        ->withMessage('Employee has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //$employee = Employee::find($id);
        return view('edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        
        $data = $request->all();
        //$employee = Employee::find($id);
        $employee->update($data);
        return redirect()
        ->route('employee.edit', $employee->id)
        ->withSuccess('Employee detail updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()
        ->route('employee.index')
        ->withSuccess('Employee deleted successfully!');
    }
}
