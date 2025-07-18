<?php

namespace App\Http\Controllers;

use App\Models\service;
use App\Models\Testimonial;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Partner;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_services'     => service::count(),
            'total_testimonials' => Testimonial::count(),
            'total_contacts'     => Contact::count(),
            'total_sliders'     => Slider::count(),
            'total_partners'     => Partner::count(),
        ]);
    }
}


