<?php

namespace App\Services;

use App\Services\ImageUploaderHelper;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ImageUploaderHelper{

    private $slugger;
    private $translator;

    public function __construct(SluggerInterface $slugger, TranslatorInterface $translator){
        $this->slugger = $slugger;
        $this->translator = $translator;
    }


    public function uploadImage($form, $formation){

        $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', $translator->trans('An error is append: ') . $e->getMessage());
                }

                $formation->setimageFilename($newFilename);
            }
    }
    

}

