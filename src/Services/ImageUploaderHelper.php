<?php

namespace App\Services;

use App\Services\ImageUploaderHelper;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageUploaderHelper{

    private $slugger;
    private $translator;
    private $params;

    public function __construct(SluggerInterface $slugger, TranslatorInterface $translator, ParameterBagInterface $params){
        $this->slugger = $slugger;
        $this->translator = $translator;
        $this->params = $params;
    }


    public function uploadImage($form, $formation){

        $errorMessage = "";
        $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->params->get('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $errorMessage = $e->getMessage();
                }
                $formation->setimageFilename($newFilename);
            }
            return $errorMessage;
    }
    

}

