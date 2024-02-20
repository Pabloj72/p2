<?php

// src/Controller/ProductController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producto;
use App\Entity\Carrito;
use App\Entity\ItemCarrito;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddProductsType;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Constructor para inyectar el EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/producto', name: 'producto')]
    public function index(): Response
    {
        // Puedes seguir usando $this->entityManager normalmente
        $products = $this->entityManager->getRepository(Producto::class)->findAll();

        return $this->render('producto/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    #[Route('/producto/{id}', name: 'ver_producto')]
    public function verProducto(Producto $producto): Response
    {
        return $this->render('producto/detalle.html.twig', [
            'controller_name' => 'ProductController',
            'producto' => $producto,
        ]);
    }

    #[Route('/carrito/agregar/{id}', name: 'agregar_al_carrito')]
    public function agregarAlCarrito(Producto $producto): Response
    {
        // Obtener o crear el carrito para el usuario actual
        $carrito = $this->getCarrito();

        // Verificar si el producto ya está en el carrito
        $itemCarrito = $this->entityManager->getRepository(ItemCarrito::class)->findOneBy([
            'carrito' => $carrito,
            'producto' => $producto,
        ]);

        if ($itemCarrito) {
            // Si el producto ya está en el carrito, incrementar la cantidad
            $itemCarrito->setCantidad($itemCarrito->getCantidad() + 1);
        } else {
            // Si el producto no está en el carrito, crear un nuevo item
            $itemCarrito = new ItemCarrito();
            $itemCarrito->setCarrito($carrito);
            $itemCarrito->setProducto($producto);
            $itemCarrito->setCantidad(1);

            $this->entityManager->persist($itemCarrito);
        }

        $this->entityManager->flush();

        return $this->redirectToRoute('ver_producto', ['id' => $producto->getId()]);
    }

    #[Route('/carrito', name: 'ver_carrito')]
    public function verCarrito(): Response
    {
        // Obtener o crear el carrito para el usuario actual
        $carrito = $this->getCarrito();

        return $this->render('carrito/ver_carrito.html.twig', [
            'controller_name' => 'ProductController',
            'carrito' => $carrito,
        ]);
    }

    // Función para obtener o crear el carrito para el usuario actual
    private function getCarrito(): Carrito
    {
        // Utiliza directamente el EntityManager inyectado
        $carrito = new Carrito();
        $this->entityManager->persist($carrito);
        $this->entityManager->flush();

        return $carrito;
    }
}
