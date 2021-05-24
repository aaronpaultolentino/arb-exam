<?php

namespace App\Http\Controllers\ExpenseManagement;

use DB;
use App\Role;
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
        if(auth()->user()->role_id == ROLE::ADMIN_ROLE_ID){
            return Expense::with('expense_category')->get();
        }else{
            return Expense::with('expense_category')->where('created_by', auth()->user()->id)->get();
        }
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
        $request->validate([
            'expense_category_id' => 'required',
            'amount' => 'required|numeric',
            'entry_date' => 'required',
        ]);

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
        $request->validate([
            'expense_category_id' => 'required',
            'amount' => 'required|numeric',
            'entry_date' => 'required',
        ]);
        
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

    public function chart()
    {
        $expenseCategories = ExpenseCategory::addSelect('id', 'name', DB::raw('(Select COALESCE(SUM(amount), 0) FROM expenses WHERE expenses.expense_category_id = expense_categories.id) as sum_amount'))->get();
        $availableColor = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ];
        $backgroundColor = [];
        $borderColor = [];

        foreach ($expenseCategories as $key => $expenseCategory) {
            # code...
            $color = rand(0,5);
            $backgroundColor[] = $availableColor[$color];
            $borderColor[] = $availableColor[$color];
        }
        
        return [
            'labels' => $expenseCategories->pluck('name'),
            'datasets' => [[
                'label' => 'Expense per category',
                'data' => $expenseCategories->pluck('sum_amount'),
                'backgroundColor' => $backgroundColor,
                'borderColor' => $borderColor,
                'borderWidth' => 1
            ]]
        ];
    }
}
