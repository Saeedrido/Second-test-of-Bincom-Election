<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\LgaRepository;

class WardController extends Controller
{
    public function __construct(
        protected LgaRepository $lgaRepository
    ) {}

    public function index($lgaId)
    {
        $wards = $this->lgaRepository->getWards($lgaId);

        return response()->json($wards);
    }
}
