<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSalesEmployeeRequest;
use App\Http\Requests\Admin\UpdateSalesEmployeeRequest;
use App\Models\SalesEmployee;
use App\Models\User;
use App\Services\Admin\SalesEmployeeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesEmployeeController extends Controller
{
    public function __construct(
        private readonly SalesEmployeeService $salesEmployeeService
    ) {
    }

    public function index(Request $request): View
    {
        abort_unless(
            auth()->user()->hasPermission('sales_employees.view'),
            403
        );

        $employees = $this->salesEmployeeService->paginate(
            perPage: 15,
            search: $request->input('search'),
            status: $request->input('status')
        );

        return view(
            'admin.sales-employees.index',
            [
                'employees' => $employees,
                'search' => $request->input('search'),
                'status' => $request->input('status'),
            ]
        );
    }

    public function create(): View
    {
        abort_unless(
            auth()->user()->hasPermission('sales_employees.create'),
            403
        );

        return view(
            'admin.sales-employees.create',
            $this->formData()
        );
    }

    public function store(
        StoreSalesEmployeeRequest $request
    ): RedirectResponse {
        $this->salesEmployeeService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.sales-employees.index')
            ->with(
                'success',
                'Sales employee created successfully.'
            );
    }

    public function edit(
        SalesEmployee $sales_employee
    ): View {
        abort_unless(
            auth()->user()->hasPermission('sales_employees.edit'),
            403
        );

        return view(
            'admin.sales-employees.edit',
            array_merge(
                [
                    'salesEmployee' => $sales_employee->load(
                        'user',
                        'manager.user'
                    ),
                ],
                $this->formData($sales_employee)
            )
        );
    }

    public function update(
        UpdateSalesEmployeeRequest $request,
        SalesEmployee $sales_employee
    ): RedirectResponse {
        $this->salesEmployeeService->update(
            $sales_employee,
            $request->validated()
        );

        return redirect()
            ->route('admin.sales-employees.index')
            ->with(
                'success',
                'Sales employee updated successfully.'
            );
    }

    public function destroy(
        SalesEmployee $sales_employee
    ): RedirectResponse {
        abort_unless(
            auth()->user()->hasPermission('sales_employees.delete'),
            403
        );

        try {
            $this->salesEmployeeService->delete(
                $sales_employee
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors(
                $e->errors()
            );
        }

        return redirect()
            ->route('admin.sales-employees.index')
            ->with(
                'success',
                'Sales employee deleted successfully.'
            );
    }

    private function formData(
        ?SalesEmployee $current = null
    ): array {
        $users = User::query()
            ->whereIn('status', ['active', 'inactive'])
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        $managers = SalesEmployee::query()
            ->with('user')
            ->when(
                $current,
                fn ($query) =>
                    $query->where('id', '!=', $current->id)
            )
            ->orderBy('employee_code')
            ->get();

        return [
            'users' => $users,
            'managers' => $managers,
        ];
    }
}