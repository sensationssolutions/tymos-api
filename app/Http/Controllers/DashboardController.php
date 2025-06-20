<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_services'     => Service::count(),
            'total_testimonials' => Testimonial::count(),
            'total_contacts'     => Contact::count(),
        ]);
    }
}
