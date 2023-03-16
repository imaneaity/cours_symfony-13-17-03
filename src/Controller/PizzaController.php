<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PizzaController extends AbstractController
{
    #[Route('/pizza/nouvelle' , name: 'app_pizza_create')]
    public function create(Request $request, PizzaRepository $repository):Response
    {

        //tester si le formulaire est envoyé
        if ($request->isMethod('POST')) {
            //récuperer les champs du formulaire
            $name = $request->request->get('name');
            $price = $request->request->get('price');
            $description = $request->request->get('description');
            $imageUrl = $request->request->get('imageUrl');

            //créer l'objet pizza avec les champs du form
            $pizza = new Pizza();
            $pizza->setName($name);
            $pizza->setPrice($price);
            $pizza->setDescription($description);
            $pizza->setImageUrl($imageUrl);

            //enregistrer la pizza dans la bd via le repository
            $repository->save($pizza, true);

            //redirection vers la liste des pizzas
        }

        //affichage de la vue qui contient le formulaire
        return $this->render('pizza/create.html.twig');
    }

}
