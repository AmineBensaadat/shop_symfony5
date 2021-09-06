<?php
namespace App\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class EasyAdminSubscriber implements EventSubscriberInterface

{
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
       $this->appKernel = $appKernel; 
    }
  
    public static function getSubscribedEvents(){
        return [
            // BeforeEntityPersistedEvent::class => ['setIllustration'],
            // BeforeEntityUpdatedEvent::class => ['updatellustration']
        ];  
    }

    // public function updatellustration(BeforeEntityUpdatedEvent $event){
    //     if($_FILES['Products']['name']['illustration']['file'] != ''){
    //         $entity = $event->getEntityInstance();

    //         $tmp_name = $entity->getIllustration();

    //         $uploaded_file_file = $_FILES['Products']['name']['illustration']['file'];
    //         $filename = uniqid();
    //         $extention = pathinfo($uploaded_file_file, PATHINFO_EXTENSION);

    //         $project_dir = $this->appKernel->getProjectDir();
    //         move_uploaded_file($tmp_name, $project_dir.'/public/uploads/'.$filename.'.'.$extention);
    //         $entity->setIllustration($filename.'.'.$extention);
    //     }
    // }

    // public function setIllustration(BeforeEntityPersistedEvent $event){

    //     $entity = $event->getEntityInstance();

    //     $tmp_name = $entity->getIllustration();

    //     $uploaded_file_file = $_FILES['Products']['name']['illustration']['file'];
    //     $filename = uniqid();
    //     $extention = pathinfo($uploaded_file_file, PATHINFO_EXTENSION);

    //     $project_dir = $this->appKernel->getProjectDir();
    //     move_uploaded_file($tmp_name, $project_dir.'/public/public/'.$filename.'.'.$extention);

    //     //$entity->setIllustration($filename.'.'.$extention);
        
    // }
}