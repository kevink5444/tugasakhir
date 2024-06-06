<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Anda dapat menambahkan logika di sini untuk mengambil data yang diperlukan dari model
        
        // Contoh data dummy
        $totalEmployees = 100;
        $presentEmployees = 80;
        $totalSalary = 50000;

        return view('dashboard', compact('totalEmployees', 'presentEmployees', 'totalSalary'));
    }
}