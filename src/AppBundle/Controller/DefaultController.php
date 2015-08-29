<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hateoas\HateoasBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
    	$esculturas = $this->traerNodos();
    	
    	//ladybug_dump_die($esculturas);
		//var_dump($nds);
		//die();
        return $this->render('AppBundle::Puzzle/puzzle.html.twig', array(
            	'esculturas' => $esculturas,
            )
        );
    }



    public function traerNodos(){
    	$url = 'http://www.resistenciarte.org/api/v1/node?pagesize=10';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
    	$data = json_decode($response, true);
    	$arrayEsculturas = array();
    	foreach ($data as $key => $nodo) {
    		if ($nodo["type"] == "escultura"){
    			
    			$titulo = "no dispone titulo";
    			$tipo = "desconocido";
    			$ubicacion = "desconocida";
    			$material = "desconocido";
    			$autor = "desconocido";
    			$premios = "no tiene";
    			$anio = "desconocido";
    			$mapa = array(
    				'lat' => "-",
    				'long' => "-",
    			);
    			$foto = "no existe";
    			$escultura = $this->traerEscultura($nodo["uri"]);
    			//ladybug_dump_die($escultura["field_fotos"]);
    			if ($escultura["title"]){
    				$titulo = $escultura["title"];
    			}
    			if ($escultura["field_tipo"]["und"][0]["tid"]){
    				$tipo = $this->infoTid($escultura["field_tipo"]["und"][0]["tid"]); 
    			}
    			if ($escultura["field_fotos"]["und"][0]["filename"]){
    				$foto = "
http://www.resistenciarte.org/sites/resistenciarte.org/files/" . $escultura["field_fotos"]["und"][0]["filename"];
    			}
    			$arrayEsculturas[$key] = array(
    				'titulo' => $titulo,
    				'imgUrl' => $foto,
    			);
    		}
    	}

    	return $arrayEsculturas;
    }

    public function traerEscultura($url){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
    	$data = json_decode($response, true);
    	
    	$laData = $data["name"];
    	return $laData;
    }

    public function infoTid($tid){

    	$url = "http://www.resistenciarte.org/api/v1/taxonomy_term/" . $tid;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
    	$data = json_decode($response, true);
    	
    	return $data;
    }
}
