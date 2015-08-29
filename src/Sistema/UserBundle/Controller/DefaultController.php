<?php

namespace Sistema\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/admin/facebook", name="user_facebook")
     * @Template()
     */
    public function userFacebookAction()
    {
        return array();
    }
}
