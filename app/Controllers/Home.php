<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $doctrine = \Config\Services::doctrine();
        $data = $doctrine->em->getRepository('App\Models\Entity\Atividade')->findOneBy(['id' => 45]);
        return view('welcome_message', ['data' => $data]);
    }
    
    public function test(){
        $doctrine = \Config\Services::doctrine();
        $data = $doctrine->em->getRepository('App\Models\Entity\Atividade')->findOneBy(['id' => 45]);
        return view('welcome_message', ['data' => $data]);
    }

}
