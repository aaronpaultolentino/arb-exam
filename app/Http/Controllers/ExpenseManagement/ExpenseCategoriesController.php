<?php

namespace App\Http\Controllers\ExpenseManagement;

use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseCategoriesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('expense_management.expense_categories');
    }

    public function all()
    {
        return ExpenseCategory::all();
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        return ExpenseCategory::findOrFail($id);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $user = ExpenseCategory::findOrFail($id);
        $data = $request->toArray();
        $data['created_by'] = auth()->user()->id;
        $user->fill($request->toArray());
        $user->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $data = $request->toArray();
        $data['created_by'] = auth()->user()->id;

        $user = new ExpenseCategory($data);
        $user->save();
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function delete(Request $request, $id)
    {
        $user = ExpenseCategory::findOrFail($id);

        $user->delete();
    }
}
