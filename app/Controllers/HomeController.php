<?php

namespace Controllers;


class HomeController extends Controller
{
    public function index()
    {
        echo "Hello from Home Controller INDEX";
    }

    public function show($id)
    {
        echo "Hello from Home Controller SHOW $id";
    }

}