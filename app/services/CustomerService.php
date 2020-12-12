<?php

namespace App\Services;

use Auth;
use DataTables;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\ActivityLog;
use App\Models\TinkAccount;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerService extends BaseService
{
    protected $customerNumberPrefix = '';

    protected $isInSanction = false;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->model->with('country')->get()->sortByDesc('created_at');
    }


    public function paginate($limit = 10)
    {
        return $this->model->with('country')->where('user_id', Auth::user()->id)->paginate($limit);
    }



    /**
     * add image
     * @param file $image
     */
    public function addDocument($document, $customerId)
    {
        $customer = $this->find($customerId);

        if ($customer) {
            $accountNumber = $customer->user->company->account_number;
            $media = $customer->addMedia($document)
                ->preservingOriginal()
                ->usingName($accountNumber)
                ->toMediaCollection(Customer::DOCUMENT);

            $media->name = $accountNumber . '-' . $media->id;
            $media->save();
            $this->activityLog($customer, 'File uploaded', 'success', $media->mime_type);
            return true;
        }
        $this->activityLog($customer, 'File upload failed', 'failed', 'Failed', 'Document Upload');
        return false;
    }

    /**
     * add image
     * @param file $image
     */
    public function addMultipleDocument($documents, $customerId)
    {
        $customer = $this->find($customerId);

        if ($customer) {
            $accountNumber = $customer->user->company->account_number;
            foreach ($documents as $document) {
                $media = $customer->addMedia($document)
                    ->preservingOriginal()
                    ->usingName($accountNumber)
                    ->toMediaCollection(Customer::DOCUMENT);

                $media->name = $accountNumber . '-' . $media->id;
                $media->save();
            }
            if (count($documents) > 1) {
                $this->activityLog($customer, count($documents) . ' verification document uploaded',  'success', 'Document Upload');
            } else {
                $this->activityLog($customer, 'Verification document uploaded', 'failed', 'Document Upload');
            }
            return true;
        }
        $this->activityLog($customer, 'Customer document upload failed', 'Failed');
        return false;
    }


    public function createCustomer(array $customerData)
    {
        $customerData['verification_token'] = $this->encrypt($customerData['email'] . '' . $customerData['user_id']);
        $customer =  $this->model->create($customerData);
        $customer->cust_no =  optional($customer->user->company)->account_number . '-' . $customer->id;
        $customer->save();
        $this->directoryCreate(optional($customer->user->company)->account_number, $customer->cust_no);
        return $customer;
    }


    private function directoryCreate($accountNumber, $customerNumber)
    {
        Storage::makeDirectory($accountNumber . '/' . $customerNumber . '/identification/passport', 7777, true);
        Storage::makeDirectory($accountNumber . '/' . $customerNumber . '/identification/selfie', 7777, true);
    }


    public function verifyCustomerById($customerId, $phoneNumber)
    {
        return $this->updateById($customerId, [
            'verification_token' => null,
            'status' => Customer::APPROVED,
            'verification_date' => Carbon::now(),
            'contact_number' => $phoneNumber,
            'is_contact_number_verified' => true
        ]);
    }


    public function createCustomerAccount(Customer $customer, $account)
    {
        return TinkAccount::create([
            'model_id' => $customer->id,
            'model_type' => get_class($customer),
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
        $query = QueryBuilder::for($this->newQuery()->where('user_id', Auth::user()->id))
            ->defaultSort('-id')
            ->with(['country', 'user']);

        return DataTables::of($query)
            ->editColumn('verification_date', function (Customer $customer) {
                return $customer->present()->verificationDate;
            })
            ->editColumn('date_of_birth', function (Customer $customer) {
                return $customer->present()->dob;
            })
            ->editColumn('country.name', function (Customer $customer) {
                return optional($customer->country)->name;
            })
            ->editColumn('bank_account_status', function (Customer $customer) {
                return $customer->present()->bankAccountStatus;
            })
            ->editColumn('document_status', function (Customer $customer) {
                return $customer->present()->documentStatus;
            })
            ->editColumn('status', function (Customer $customer) {
                return $customer->present()->status;
            })
            ->editColumn('name', function (Customer $customer) {
                $name = $customer->present()->name;
                $photo = $customer->present()->getCapturePhoto;

                return '<img src="' . $photo . '" alt="" width="45"/>
                    <a class="micro" href="' . route('onboarding.customer-detail', ['id' => $customer->id]) . '">' .   $name . '</a>
                ';
            })
            ->editColumn('bankStatusColorClass', function (Customer $customer) {
                return $customer->present()->bankAccountStatusColor;
            })
            ->editColumn('statusColorClass', function (Customer $customer) {
                return $customer->present()->statusColor;
            })
            ->editColumn('documentStatusColorClass', function (Customer $customer) {
                return $customer->present()->documentStatusColor;
            })
            ->rawColumns(['name', 'bank_account_status', 'document_status', 'status'])
            ->addIndexColumn()
            ->toJson();
    }

    public function createActivityLog($customer, $logMessage, $status = null)
    {
        $this->activityLog($customer, $logMessage, $status);
    }

    public function checkCustomerIsInSanctionList($customer)
    {
        $content = null;
        $files = Storage::disk('public')->files('sanction-list');

        foreach ($files as $file) {
            $content = Storage::disk('public')->get($file);

            $this->findCustomerIsInSanctionList($customer, $content);
        }

        return $this->isInSanction;
    }

    public function findCustomerIsInSanctionList($customer, $content)
    {
        if ($customer->name) {
            if (stripos($content, $customer->name)) {
                $this->isInSanction = true;
            }
        }

        if ($customer->passport_number) {
            if (stripos($content, $customer->passport_number)) {
                $this->isInSanction = true;
            }
        }

        if ($customer->country_id && $customer->address_1 && $customer->address_2) {
            $address = $customer->address_1 . ', ' . $customer->address_2 . ', ' . optional($customer->country)->name;
            if (stripos($content, $address)) {
                $this->isInSanction = true;
            }
        }
    }

    public function customerLog()
    {
        $query = QueryBuilder::for($this->newQuery())
            ->defaultSort('-id')
            ->with(['country', 'user']);

        return DataTables::of($query)
            ->editColumn('verification_date', function (Customer $customer) {
                return $customer->present()->verificationDate;
            })
            ->editColumn('date_of_birth', function (Customer $customer) {
                return $customer->present()->dob;
            })
            ->editColumn('country.name', function (Customer $customer) {
                return optional($customer->country)->name;
            })
            ->editColumn('bank_account_status', function (Customer $customer) {
                return $customer->present()->bankAccountStatus;
            })
            ->editColumn('document_status', function (Customer $customer) {
                return $customer->present()->documentStatus;
            })
            ->editColumn('status', function (Customer $customer) {
                return $customer->present()->status;
            })
            ->editColumn('name', function (Customer $customer) {
                return $customer->present()->name;
            })
            ->rawColumns(['name', 'bank_account_status', 'document_status', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
}
