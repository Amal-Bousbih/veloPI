<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Todo;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/formulaire/{id}/{idz}", name="homepage")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo;

        # Add form fields
        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class, array('label'=> 'Todo Title', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('category', TextType::class, array('label'=> 'Todo Category','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextareaType::class, array('label'=> 'Todo Description','attr' => array('class' => 'form-control')))
            ->add('Save', SubmitType::class, array('label'=> 'Create Todo', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        # Handle form and recaptcha response
        $form->handleRequest($request);

        # check if form is submitted and Recaptcha response is success
        if($form->isSubmitted() &&  $form->isValid() && $this->captchaverify($request->get('g-recaptcha-response'))){
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();

            # set form data
            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);

            # finally add data in database
            $sn = $this->getDoctrine()->getManager();
            $sn -> persist($todo);
            $sn -> flush();

            $this->addFlash(
                'notice',
                'Todo Added'
            );
            return $this->redirectToRoute('homepage');
        }

        # check if captcha response isn't get throw a message
        if($form->isSubmitted() &&  $form->isValid() && !$this->captchaverify($request->get('g-recaptcha-response'))){

            $this->addFlash(
                'error',
                'Captcha Require'
            );
        }

        return $this->render('default/form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    # get success response from recaptcha and return it to controller
    function captchaverify($recaptcha){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "secret"=>"6LeTXQgUAAAAALExcpzgCxWdnWjJcPDoMfK3oKGi","response"=>$recaptcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data->success;
    }

}
