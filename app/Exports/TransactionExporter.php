<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExporter implements FromCollection
{
    public $transactions;

    /**
     * TransactionExporter constructor.
     */
    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @return array
     */
    public function collection()
    {
        $collections = [];
        $totalAdded = 0;
        $totalSpent = 0;
        $collections[]=[
            trans("companies::companies.attributes.transaction_id"),
            trans("app.transaction_type"),
            trans("companies::companies.attributes.user_trans"),
            trans("companies::companies.attributes.name"),
            trans("app.before_transaction"),
            trans("app.add_points"),
            trans("app.used_points"),
            trans("app.after_transactions"),
            trans("companies::companies.attributes.created_at")
        ];
        foreach ($this->transactions as $transaction) {
            $totalAdded += ($transaction->before_points < $transaction->after_points) ? $transaction->points : 0;
            $totalSpent += ($transaction->before_points >= $transaction->after_points) ? $transaction->points : 0;
            $collections[] = [
                $transaction->id,
                $transaction->type,
                @$transaction->user->first_name . ' ' . @$transaction->user->last_name,
                $transaction->user->in_company ? $transaction->user->company[0]->name : '',
                $transaction->before_points,
                $transaction->before_points < $transaction->after_points ? $transaction->points : 0,
                $transaction->before_points < $transaction->after_points ? 0 : $transaction->points,
                $transaction->after_points,
                app()->getLocale() == "ar" ? arabic_date($transaction->created_at->format('Y-m-d h:i a')) : $transaction->created_at->format('Y-m-d h:i a')
            ];
        }
        $collections[]=[
            '', '', '', '', '',
            trans('app.total').' '.$totalSpent,
            trans('app.total').' '.$totalAdded,
            '',''
        ];
        return collect($collections);
    }
}
