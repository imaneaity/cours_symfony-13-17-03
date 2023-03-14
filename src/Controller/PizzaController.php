<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    #[Route('/pizza', name: 'app_pizza')]
    public function index(): Response
    {
        return $this->render('pizza/index.html.twig', [
            'controller_name' => 'PizzaController',
        ]);
    }


    #[Route('/pizza/nouvelle', name: 'app_pizza_newPizza')]
    public function newPizza(PizzaRepository $repository): Response
    {
        //créer une nouvelle pizza l'objet pizza
        $pizza = new Pizza();
        $pizza->setName('Régina');
        $pizza->setPrice(15.99);

        //enregistrer la pizza dans la bd
        $repository->save($pizza, true);

        //recuperer une pizza selon son id
        $pizza1 = $repository->find(1);

        var_dump($pizza1);
        echo '<br>';

        //recup de toutes les pizzas dans une liste
        $pizzas = $repository->findAll();
        var_dump($pizzas);
        echo '<br>';

        //supprimer une pizza
        $repository->remove($pizza, true);


        //afficher une confirmation
        return new Response("La pizza avec l'id {$pizza->getId()} a bien été enregistré");
    }



//les 2 méthodes suivantes font la même chose:

//appel au repository par nous même
    #[Route('/pizza/{id}/afficher' , name:'app_pizza_show')]
    public function show(int $id, PizzaRepository $repository):Response //recup id de la route
    {
         //recuperation de la pizza qui a l'id $id
        $pizza= $repository->find($id);
        //affichage du nom de la pizza
        return new Response("nom: {$pizza->getName()}"); 
    }

    // grace à  FrameworkExtraBundle la 2eme méthode résout le id en pizza directement
    //donc l'appel à  $repository->find() est fait automatiquement en arriére plan
    #[Route('/pizza/{id}/afficher2' , name:'app_pizza_show2')]
    public function show2(Pizza $pizza):Response // résolution de la pizza selon l'id
    {
        //affichage du nom de la pizza
        return new Response("nom: {$pizza->getName()}");
    }


}
