<?php declare(strict_types=1);

namespace App\Controller\Photo;

use App\Criticalmass\Image\PhotoUploader\PhotoUploaderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Controller\AbstractController;
use App\Entity\Photo;
use App\Entity\Ride;
use App\Criticalmass\Image\PhotoGps\PhotoGps;
use PHPExif\Reader\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class PhotoUploadController extends AbstractController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @ParamConverter("ride", class="App:Ride")
     */
    public function uploadAction(Request $request, UserInterface $user = null, PhotoGps $photoGps, Ride $ride, PhotoUploaderInterface $photoUploader): Response
    {
        $this->errorIfFeatureDisabled('photos');

        if (Request::METHOD_POST === $request->getMethod()) {
            return $this->uploadPostAction($request, $user, $photoGps, $ride, $photoUploader);
        } else {
            return $this->uploadGetAction($request, $user, $photoGps, $ride, $photoUploader);
        }
    }

    protected function uploadGetAction(Request $request, UserInterface $user = null, PhotoGps $photoGps, Ride $ride, PhotoUploaderInterface $photoUploader): Response
    {
        return $this->render('PhotoUpload/upload.html.twig', [
            'ride' => $ride,
        ]);
    }

    protected function uploadPostAction(Request $request, UserInterface $user = null, PhotoGps $photoGps, Ride $ride, PhotoUploaderInterface $photoUploader): Response
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->get('file');

        if ($uploadedFile) {
            $photoUploader
                ->setRide($ride)
                ->setUser($user)
                ->addFile($uploadedFile->getPathname());
        }

        return new Response('');
    }
}