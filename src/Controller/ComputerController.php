<?php
namespace App\Controller;
use App\Entity\Item;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;






class ComputerController extends AbstractController {
    /**
     * @Route("/item/item_list", name="item_list")
     */
    public function index (){

        $items = $this->getDoctrine()->getRepository(Item::class)->findAll();

        return $this->render('computers/index.html.twig', array('items' => $items));
    }

    /**
     * @Route("/item/new")
     */
    public function new(Request $request){
        $item = new Item();

        $form = $this->createFormBuilder($item)
        ->add('title', TextType::class, array('label' => 'Naziv:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('name', TextType::class, array('label' => 'Korisnik:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('invnum', TextType::class, array('label' => 'Inventurni broj:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('date', DateType::class, array('label' => 'Datum:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('save', SubmitType::class, array('label' => 'Spremi', 'attr' => array('class' => 'btn btn-primary mt-4')))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();
            return $this->redirectToRoute('item_list');
            
          }
    

        return $this->render('computers/new.html.twig', array('form' => $form->createView()));
    }
  
    /**
     * @Route("/item/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($item);
        $entityManager->flush();
        
        $response = new Response();
        $response->send();
      }

    /**
     * @Route("/item/edit/{id}")
     */
    public function edit(Request $request, $id){
        $item = new Item();
        $item = $this->getDoctrine()->getRepository(Item::class)->find($id);
        $form = $this->createFormBuilder($item)
        ->add('title', TextType::class, array('label' => 'Naziv:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('name', TextType::class, array('label' => 'Korisnik:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('invnum', TextType::class, array('label' => 'Inventurni broj:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('date', DateType::class, array('label' => 'Datum:', 'attr'=>array('class'=>'form-control mb-3')))
        ->add('save', SubmitType::class, array('label' => 'Spremi', 'attr' => array('class' => 'btn btn-primary mt-4')))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->flush();
            return $this->redirectToRoute('item_list');
          }
    

        return $this->render('computers/edit.html.twig', array('form' => $form->createView()));
    }

    
}

?>