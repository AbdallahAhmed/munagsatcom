<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use TCPDF;

class InvoiceController extends Controller
{
    /**
     * GET {lang?}/invoice/{id}
     * @route invoices.pdf
     * @param Request $request
     * @throws \Throwable
     */
    public function invoices(Request $request, $id)
    {
        $transaction = Transaction::whereIn('action', ['tenders.buy', 'add.chance', 'center.add','points.buy'])
            ->where('id', $id)
            ->firstOrFail();
        if ($transaction->user_id == fauth()->id() ||
            (fauth()->user()->in_company && fauth()->user()->company[0]->id == $transaction->company_id)) {
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_ORIENTATION, true, 'UTF-8', false);


            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $lg = Array();
            $lg['a_meta_charset'] = 'UTF-8';
            $lg['a_meta_dir'] = 'rtl';
            $lg['a_meta_language'] = 'fa';
            $lg['w_page'] = 'page';
            $pdf->setLanguageArray($lg);
            $pdf->SetFont('dejavusans', '', 12);
            $pdf->AddPage();
            $pdf->Ln();
            $pdf->setRTL(true);

            $htmlcontent = view('pdf.invoice', ['transaction' => $transaction])->render();
            $pdf->WriteHTML($htmlcontent, true, 0, true, 0);

            $pdf->Ln();
            $pdf->Output('invoice.pdf', 'I');
        }
    }
}
