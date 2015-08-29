<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use MWSimple\Bundle\AdminCrudBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use AppBundle\Form\PostFilterType;

/**
 * Post controller.
 * @author Nombre Apellido <name@gmail.com>
 *
 * @Route("/post")
 */
class PostController extends Controller
{
    /**
     * Configuration file.
     */
    protected $config = array(
        'yml' => 'AppBundle/Resources/config/Post.yml',
    );

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $this->config['filterType'] = new PostFilterType();
        $response = parent::indexAction();

        return $response;
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/", name="post_create")
     * @Method("POST")
     * @Template("AppBundle:Post:new.html.twig")
     */
    public function createAction()
    {
        $this->config['newType'] = new PostType();
        $response = parent::createAction();

        return $response;
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="post_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->config['newType'] = new PostType();
        $response = parent::newAction();

        return $response;
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id}", name="post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $response = parent::showAction($id);

        return $response;
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $this->config['editType'] = new PostType();
        $response = parent::editAction($id);

        return $response;
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}", name="post_update")
     * @Method("PUT")
     * @Template("AppBundle:Post:edit.html.twig")
     */
    public function updateAction($id)
    {
        $this->config['editType'] = new PostType();
        $response = parent::updateAction($id);

        return $response;
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}", name="post_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $response = parent::deleteAction($id);

        return $response;
    }

    /**
     * Exporter Post.
     *
     * @Route("/exporter/{format}", name="post_export")
     */
    public function getExporter($format)
    {
        $response = parent::exportCsvAction($format);

        return $response;
    }
}