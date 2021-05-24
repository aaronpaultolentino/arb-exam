<?php

namespace App\Http\Controllers\ExpenseManagement;

use App\Expense;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpensesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('expense_management.expenses', [
            'expense_categories' => ExpenseCategory::all(),
        ]);
    }

    public function all()
    {
        return Expense::with('expense_category')->get();
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        return Expense::findOrFail($id);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $user = Expense::findOrFail($id);
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

        $user = new Expense($data);
        $user->save();
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function delete(Request $request, $id)
    {
        $user = Expense::findOrFail($id);

        $user->delete();
    }
}
