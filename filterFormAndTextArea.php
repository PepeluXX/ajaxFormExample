<?php

/*
*@file
*Contains \Drupal\busca_alumnos\Form\BuscaAlumnosForm.
*/

namespace Drupal\busca_alumnos\Form;

use Drupal\Core\Form\Formbase;
use Drupal\Core\Form\FormStateInterface;

class BuscaAlumnosForm extends FormBase{
  /**
    *{@inheritdoc}     
    */
 public function getFormId(){
       return 'busca_alumnos_form'     
    }
    
    
     /**
    *{@inheritdoc}     
    */
 
    public function buildForm(array $form, FormStateInterface $form_state){

        $uid = \Drupal::currentUser()->id();       
        
       //form to filter by course or student
       
        $form['filtro']=[
            '#title'=>$this->t('Filtrar Aviso por: '),
            '#type' =>'select',
            '#options'=>$this->getFiltro(), //returns two strings: 'Course','Student'
            '#empty_option'=>$this->t('-Seleccione filtro-'),
            '#ajax'=>[
                'callback'=>'::updateCursosProfesor',
                'wrapper' =>'cursos-profesor',
            ],
        ];
        
        //form to show the courses of the proffesor
        
        $form['cursos_profesor']=[
            '#type'=>'container',
            '#attributes'=>['id'=>'cursos-profesor'],
        ];
        
        
        //form to show the title of the advices
        
        $form['titulos_avisos']=[
            '#type'=>'container',
            '#attributes'=>['id'=>'titulos-avisos'],
        ];
        
        //form to show the text of the advices
        
        $form['texto_aviso']=[
            '#type'=>'container',
            '#attributes'=>['id'=>'texto-aviso'],
        ];
        
             
        $filtro = $form_state -> getValue('filtro');
        
        //if something is selected on the first list 'filtro'
        
        if(!empty($filtro)){
                        
           //if the first option was selected
           
            if($filtro==1){
                     
                $form['cursos_profesor']['curso']=[
                '#type' => 'select',
                '#title'=>$this->t('Mis Cursos: '),
                '#options'=>$this->getCursosProfesor($uid), //get the courses of the proffesor
                '#empty_option'=>'-Seleccione Curso-',
                '#ajax'=>[
                'callback'=>'::updateTitulosAvisos',
                'wrapper' =>'titulos-avisos',
            ],
                
            ];  
          
                  $curso_seleccionado = $form_state->getValue('curso');
                  
                  //if something was selected on the second list 'cursos_profesor'
                  
                  if(!empty($curso_seleccionado)){
                    
                    $form['titulos_avisos']['titulo']=[
                    '#type' => 'select',
                    '#title'=>$this->t('Titulos Avisos: '),
                    '#options'=> $this->getTitulosAvisos($uid,$curso_seleccionado), //get the titles of the advices
                    '#empty_option'=>'-Titulo de Aviso-', 
                     '#ajax'=>[
                        'callback'=>'::updateTextoAviso',
                        'wrapper' =>'texto-aviso',
                        
                        ],
                    ];
                    
                  }
                  
                   $aviso_seleccionado=$form_state->getValue('titulo');
                    
                    //if something is selected on the third list 'titulos_avisos'
                    
                   if(!empty($aviso_seleccionado)){
                       
                        $paflus=$this->getTextoAvisos($uid,$curso_seleccionado,$aviso_seleccionado);
                        
                        $form['texto_aviso']['texto']=[
                          '#type' => 'textarea',
                          '#title' => $this->t('Advice'),
                          '#value' => $paflus,                          
                         // '#attributes'=>['readonly' => 'readonly'],
                          '#disabled'=>TRUE,
                          '#size' => 100,
                          '#maxlength' => 10000,
                           ]; 
                                              
                   }               
            }
            
            //If the second option is selected in the firs list 'filtro'
            //it´s unfinished, but works the same as the previos part
            
            if($filtro==2){
                
                 $form['cursos_profesor']['curso']=[
                '#type' => 'select',
                '#title'=>$this->t('Curso del alumno: '),
                '#options'=>$this->getCursosProfesor($uid),
                '#empty_option'=>'-Curso del Alumno-',
                '#ajax'=>[
                'callback'=>'::updateTitulosAvisos',
                'wrapper' =>'titulos-avisos',
            ],                
            ]; 
                 
               $curso_seleccionado = $form_state->getValue('curso');
 
               if(!empty($curso_seleccionado)){
                    
                    $form['titulos_avisos']['titulo']=[
                    '#type' => 'select',
                    '#title'=>$this->t('Titulos Avisos: '),
                    '#options'=> $this->getTitulosAvisos($uid,$curso_seleccionado),
                    '#empty_option'=>'-Titulo Aviso-',                
                    ]; 
                   }  
            }           
        }
      
      /////////////////////////////////
        
        
        $form['actions'] = [
            '#type' => 'actions',
            'submit' => [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
      ],
    ];
        return $form;
    }
    
  public function updateTextoAviso(array $form, FormStateInterface $form_state){
        
        return $form['texto_aviso'];
    }
    
     public function updateTitulosAvisos(array $form, FormStateInterface $form_state){
        
        return $form['titulos_avisos'];
    }
    
    public function updateCursosProfesor(array $form, FormStateInterface $form_state){
        
        return $form['cursos_profesor'];
    }
  
    public funtion validateForm(array &$form, FormStateInterface $form_state){TODO}
    
    public function submitForm(array &$form, FormStateInterface $form_state){TODO}
    
