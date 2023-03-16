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
            return $this->redirectToRoute('app_pizza_list');
        }

        //affichage de la vue qui contient le formulaire
        return $this->render('pizza/create.html.twig');
    }

    #[Route('/pizza/liste', name:'app_pizza_list')]
    public function list(PizzaRepository $repository):Response
    {
        //recuperer la liste des pizzas de la bd via le repo
        $pizzas = $repository->findAll();
        //afficher la liste dans le twig
            return $this->render('pizza/list.html.twig', ['pizzas' => $pizzas]);
    }

    #[Route('/pizza/{id}/modifier', name:'app_pizza_update')]
    public function update(int $id, PizzaRepository $repository, Request $request):Response
    {
        //recuperer la pizza avec l'id specifié dans la route
        $pizza = $repository->find($id);


        //tester si le formulaire est envoyé
        if ($request->isMethod('POST')) {
            //recuperer les champs du formulaire
            $name= $request->request->get('name');
            $price= $request->request->get('price');
            $description= $request->request->get('description');
            $imageUrl= $request->request->get('imageUrl');


            //modifier $pizza avec les nouvelles données
            $pizza->setName($name);
            $pizza->setPrice($price);
            $pizza->setDescription($description);
            $pizza->setImageUrl($imageUrl);

            //enregistrer dans la bd via le repo
            $repository->save($pizza, true);

            //redirection vers la liste des pizzas
            return $this->redirectToRoute('app_pizza_list');
        }

        //affichage du form de modification
        return $this->render('pizza/update.html.twig',[
            'pizza' => $pizza
        ]);
    }

}
