<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DenunciaController extends Controller
{

    public function index(){
        return view('denuncia.index');
    }

    public function create(){
        return view('denuncia.create');
    }

    public function store(){

    }


}
