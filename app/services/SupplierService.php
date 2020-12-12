<?php

namespace App\Services;

use App\Exports\SupplierExport;
use App\Imports\SupplierImport;
use App\Models\Supplier;
use App\Models\TinkAccount;
use Auth;
use Carbon\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use DataTables;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as MaatExcel;

class SupplierService extends BaseService
{
    protected $supplierNumberPrefix = '';
    public function __construct(Supplier $supplier)
    {
        $this->model = $supplier;
    }

    public function createSupplier(array $supplierData)
    {
        $supplierData['verification_token'] = $this->encrypt($supplierData['email'] . '' . $supplierData['user_id']);
        $supplier =  $this->model->create($supplierData);
        $supplier->cust_no = optional($supplier->user->company)->account_number . '-' . $supplier->id;
        $supplier->save();
        return $supplier;
    }


    public function createCustomerAccount(Supplier $supplier, $account)
    {
        return TinkAccount::create([
            'model_id' => $supplier->id,
            'model_type' => get_class($supplier),
            'account_number' => $account->accountNumber,
            'available_credit' => $account->availableCredit,
            'balance' => $account->balance,
            'bank_id' => $account->bankId,
            'certain_date' => $account->certainDate,
            'credentials_id' => $account->credentialsId,
            'tink_account_id' => $account->id,
            'name' => $account->name,
            'type' => $account->type,
            'user_id' => $account->userId,
            'user_modified_name' => $account->userModifiedType,
            'holder_name' => $account->holderName,
            'currency_code' => $account->currencyCode
        ]);
    }


    public function dataTables()
    {
        $query = QueryBuilder::for($this->newQuery()->where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc'))
            // ->defaultSort('-id')
            ->with(['country', 'user']);

        return DataTables::of($query)
            ->editColumn('id', function (Supplier $supplier) {
                return '
                     <label class="cont check-pad">
                        <input type="checkbox" value="' . $supplier->id . '" name="supplierId[]">
                        <span class="checkmark"></span>
                    </label>
                ';
            })
            ->editColumn('verification_date', function (Supplier $supplier) {
                return $supplier->present()->verificationDate;
            })
            ->editColumn('country.name', function (Supplier $supplier) {
                return optional($supplier->country)->name;
            })
            ->editColumn('bank_account_status', function (Supplier $supplier) {
                return $supplier->present()->bankAccountStatus;
            })
            ->editColumn('document_status', function (Supplier $supplier) {
                return $supplier->present()->documentStatus;
            })
            ->editColumn('status', function (Supplier $supplier) {
                return $supplier->present()->status;
            })
            ->editColumn('name', function (Supplier $supplier) {
                $name = $supplier->present()->name;

                return '
                    <a class="micro d-flex align-items-center" href="' . route('sVault.supplier.verification', ['supplier_id' => $supplier->id]) . '">
                    <img src="' . asset("assets/images/micro_icon.png") . '" alt="">' . $name  . '</a>
                ';
            })
            ->editColumn('bankAccountStatusColorClass', function (Supplier $supplier) {
                return $supplier->present()->bankAccountStatusColor;
            })
            ->editColumn('statusColorClass', function (Supplier $supplier) {
                return $supplier->present()->statusColor;
            })
            ->editColumn('documentStatusClass', function (Supplier $supplier) {
                return $supplier->present()->documentStatus;
            })
            ->editColumn('updatedAt', function (Supplier $supplier) {
                return $supplier->updated_at;
            })
            ->rawColumns(['id', 'name', 'bank_account_status', 'document_status', 'status'])
            ->addIndexColumn()
            ->toJson();
    }


    public function paginate($limit = 10)
    {
        return $this->model->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate($limit);
    }


    public function exportCSV()
    {
        return (new SupplierExport($this->model->where('user_id', Auth::user()->id)))
            ->download('Suppliers-' . now() . '.csv', Excel::CSV, [
                'X-Vapor-Base64-Encode' => 'True'
            ]);
    }


    public function importCSV($file)
    {
        return MaatExcel::import(new SupplierImport, $file);
    }

    public function view($id)
    {
        return $this->model->find($id);
    }

    public function addMultipleDocument($documents, $supplierId)
    {
        $supplier = $this->find($supplierId);

        if ($supplier) {
            $accountNumber = $supplier->user->company->account_number;
            foreach ($documents as $document) {
                $media = $supplier->addMedia($document)
                    ->preservingOriginal()
                    ->usingName($accountNumber)
                    ->toMediaCollection(supplier::DOCUMENT);

                $media->name = $accountNumber . '-' . $media->id;
                $media->save();
            }
            $this->activityLog($supplier, 'supplier document uploaded successfully', 'success', 'Bank Statement');
            return true;
        }
        $this->activityLog($supplier, 'supplier document upload failed', 'failed', 'Bank Statement');
        return false;
    }
}
