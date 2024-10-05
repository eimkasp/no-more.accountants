<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //

    public function index_create() {

        return view('pages.index');
    }

    public function index_upload() {

        return view('pages.upload');
    }
}
