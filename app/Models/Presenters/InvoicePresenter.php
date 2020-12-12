<?php

namespace App\Models\Presenters;

use App\Models\Invoice;
use App\Models\MediaInvoiceItems;
use App\Models\MediaTraining;
use Carbon\Carbon;
use Laracasts\Presenter\Presenter;

class InvoicePresenter extends Presenter
{
    public function status(): string
    {
        return Invoice::STATUS[$this->entity->status];
    }

    public function invoiceStatus()
    {
        $status = 0;
        $invoices = $this->invoiceDoc();

        foreach ($invoices as $invoice) {
            $status = $invoice->doc_status ?? 0;
        }

        return isset(Invoice::INVOICE_MEDIA_STATUS[$status]) ? Invoice::INVOICE_MEDIA_STATUS[$status] : Invoice::INVOICE_MEDIA_STATUS[0];
    }

    public function invoiceStatusColor()
    {
        $status = 0;
        $invoices = $this->invoiceDoc();

        foreach ($invoices as $invoice) {
            $status = $invoice->doc_status ?? 0;
        }

        return isset(Invoice::INVOICE_MEDIA_STATUS_COLOR[$status]) ? Invoice::INVOICE_MEDIA_STATUS_COLOR[$status] : Invoice::INVOICE_MEDIA_STATUS_COLOR[0];
    }

    public function statusColor(): string
    {
        return Invoice::STATUS_COLOUR[$this->entity->status];
    }


    public function invoiceDoc()
    {
        return $this->entity->getMedia(Invoice::DOCUMENT);
    }

    public function issueDate()
    {
        return $this->entity->issue_date ? Carbon::parse($this->entity->issue_date)->format('d/m/Y') : '';
    }


    public function uploadedAt()
    {
        return $this->entity->created_at ? Carbon::parse($this->entity->created_at)->format('d/m/Y H:s:i') : '';
    }

    public function invoiceMediaTraining($id)
    {
        return MediaTraining::where('media_id', $id)->latest()->first();
    }

    public function invoiceMediaItems($id)
    {
        return MediaInvoiceItems::with('mediaTrainingItems')->where('media_id', $id)->get();
    }
}
