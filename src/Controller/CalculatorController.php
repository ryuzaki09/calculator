<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Helper\CalculatorHelper;

class CalculatorController extends Controller
{

    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('num1', IntegerType::class)
            ->add('operator', ChoiceType::class, array(
                    'choices' => array(
                        "+" => "plus",   
                        "-" => "subtract",   
                        "*" => "multiply",   
                        "/" => "divide"
                    )
                )
            )
            ->add('num2', IntegerType::class)
            ->add('calculate', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $result = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $request->request->all();
            $num1 = $formData['form']['num1'];
            $num2 = $formData['form']['num2'];
            $operator = $formData['form']['operator'];
            $result = CalculatorHelper::calculate($num1, $num2, $operator);
        }

        $data = array(
            "title" => "My Calculator",
            "form" => $form->createView(),
            "form_action2" => "/calculator/custom-calculate",
            "result" => $result
        );

        return $this->render('calculator.html.twig', $data);
    }

    public function customCalculate(Request $request)
    {
        $custom_input = $request->request->get('custom_input');
        if (!is_numeric(substr($custom_input, -1))) {
            $this->addFlash(
                'custom_result',
                'check input and try again'
            );
            return $this->redirectToRoute('calculator');
        }

        $result = eval("return $custom_input;");
        $this->addFlash(
            'custom_result',
            'Total is: '.$result
        );

        return $this->redirectToRoute('calculator');
    }

}
