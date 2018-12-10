<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Dot\Pages\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public $data = array();

    public function show(Request $request, $slug){
        $this->data['page'] = $page = Page::where('slug', $slug)->firstOrFail();

        return view('page-details', $this->data);
    }

    public function contactUs(Request $request){
        if($request->method() == "POST")
            Mail::to(option('site_email'))->send(new ContactMail($request));
        else{
            return view('contact');
        }
    }
}
