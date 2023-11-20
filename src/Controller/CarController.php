<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/car')]
class CarController extends AbstractController
{

    #[Route('/', name: 'create_new_car', methods: ["POST"])]
    public function newCar(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $car = new Car();
        $car->setModel($parameters["model"]);
        $car->setPlate($parameters["plate"]);

        $em->persist($car);
        $em->flush();

        return $this->json("Car saved");
    }

    #[Route('/', name: 'get_all_cars')]
    public function index(CarRepository $carRepository): JsonResponse
    {
        $cars = $carRepository->findAll();
        return $this->json($cars);
    }


}
