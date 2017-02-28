<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Libro;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $libros = [];
        $dql = "";

        if( !empty( $request->get("keyword") ) ) {

            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $qb->select('l')
                ->from('AppBundle\Entity\Libro', 'l')
                //->orderBy('u.name', 'ASC')
                //->setMaxResults( 1 );
            ;

            $exp = $qb->expr()->orX();



            if( empty( $request->get("codigo") )
                && empty( $request->get("nombre") )
                && empty( $request->get("autor") )
                && empty( $request->get("editorial") )
                && empty( $request->get("pais") )){

                $qb->where('l.codigo = :codigo');
                $qb->setParameter('codigo', $request->get("keyword"));

            }else{
                if($request->get("codigo") == 1) $exp->add($qb->expr()->eq('l.codigo', ':codigo'));
                if($request->get("nombre") == 1) $exp->add($qb->expr()->like('l.nombre', ':nombre') );
                if($request->get("autor") == 1) $exp->add($qb->expr()->like('l.autor', ':autor') );
                if($request->get("editorial") == 1) $exp->add($qb->expr()->like('l.editorial', ':editorial'));
                if($request->get("pais") == 1) $exp->add($qb->expr()->like('l.pais', ':pais') );

                $qb->add('where', $exp);

                if($request->get("codigo") == 1) $qb->setParameter('codigo', $request->get("keyword") );
                if($request->get("nombre") == 1) $qb->setParameter('nombre', "%".$request->get("keyword")."%" );
                if($request->get("autor") == 1) $qb->setParameter('autor', "%".$request->get("keyword")."%" );
                if($request->get("editorial") == 1) $qb->setParameter('editorial', "%".$request->get("keyword")."%" );
                if($request->get("pais") == 1) $qb->setParameter('pais', "%".$request->get("keyword")."%" );

            }


            $query = $qb->getQuery();

            $dql = $qb->getDql();

            $libros = $query->getArrayResult();

        }

        //$form = $this->createForm(FormType::class, null, array('method' => 'GET')->add('keyword', TextType::class);
        //return $this->render('default/index.html.twig',[ 'libros' => array( ),'form' => $form->createView()] );
        return $this->render('default/index.html.twig',[ 'libros' => $libros, 'dql' => $dql ] );
    }

    /**
     * @Route("/ingresar", name="ingresar")
     */
    public function ingresarAction(Request $request)
    {
        $libro = new Libro();
        $form = $this->createFormBuilder($libro)
            ->add('codigo', TextType::class)
            ->add('nombre', TextType::class)
            ->add('autor', TextType::class)
            ->add('editorial', TextType::class)
            ->add('pais', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Ingresar libro'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $libro = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($libro);
            $em->flush();

            unset($libro);
            unset($form);

            $libro = new Libro();
            $form = $this->createFormBuilder($libro)
                ->add('codigo', TextType::class)
                ->add('nombre', TextType::class)
                ->add('autor', TextType::class)
                ->add('editorial', TextType::class)
                ->add('pais', TextType::class)
                ->add('save', SubmitType::class, array('label' => 'Ingresar libro'))
                ->getForm();
        }

        return $this->render('default/ingresar.html.twig',['form' => $form->createView()] );

    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('default/about.html.twig');
    }
}
