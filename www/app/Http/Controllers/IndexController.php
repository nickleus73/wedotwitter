<?php
namespace App\Http\Controllers;


class IndexController extends Controller
{
    /**
     * @Get("/")
     */
    public function index() {
        return view('welcome');
    }
}