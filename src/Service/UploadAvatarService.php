<?php

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  UploadAvatarService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

namespace App\Service;

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  UploadAvatarService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * PHP version 7
 *
 * @category App\Service
 * @package  UploadAvatarService.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://plateformweb.com
 */
class UploadAvatarService
{
    /**
     * ParameterBagInterface
     *
     * @var objet
     */
    private $_params;   

    /**
     * TranslatorInterface 
     *
     * @var objet
     */
    private $_translator;

    /**
     * Language traduction
     *
     * @var string
     */
    private $_langue; 
    
    /**
     * Chemin absolue dossier User
     * Photos / vidéos / autres
     *
     * @var string
     */
    private $_folder;

    /**
     * Nom du fichier uploader
     *
     * @var string
     */
    private $_renameFile;

    /**
     * Type de dossier 
     * Photos ou Vidéos
     *
     * @var string
     */
    private $_type;

    /**
     * Extensions autorisées
     *
     * @var array
     */
    private $_extensions;

    /**
     * Mimes autorisées
     *
     * @var array
     */
    private $_mimes;

    /**
     * Largeur max image upload
     *
     * @var integer
     */
    private $_maxWidth;

    /**
     * Hauteur max image upload
     *
     * @var integer
     */
    private $_maxHeight;

    /**
     * Void __construct()
     * 
     * @param ParameterBagInterface $params     Objet
     * @param TranslatorInterface   $translator Objet
     */
    public function __construct(
        ParameterBagInterface $params, 
        TranslatorInterface $translator
    ) {
        $this->_params = $params;
        $this->_translator = $translator;
    }

    /**
     * Langue pour traduction
     *
     * @param string $getLocale getLocale
     * 
     * @return void
     */
    public function setLanguage(string $getLocale) 
    {
        $this->_langue = $getLocale;
    }

    /**
     * Getter langue
     *
     * @return string
     */
    public function getLanguage(): string 
    {
        return $this->_langue;
    }

    /**
     * Setter 
     * Chemin absolue pour uploader la photo ou vidéo
     *
     * @param string $usercrypt usercrypt
     * @param string $type      photos ou vidéos
     * 
     * @return void
     */
    public function setFolder(string $usercrypt, string $type = 'photos')
    {
        $this->_folder = $this->_params->get('avatar_root');
        $this->_type = $type;
        $this->_extensions = $this->_params->get(
            "extensions".ucfirst(strtolower($type))
        );
        $this->_mimes = $this->_params->get(
            "mimeType".ucfirst(strtolower($type))
        );

        $safeFilename = "|*|";
        $safeFilename .= $usercrypt;
        $safeFilename .= "|-|";
        $safeFilename .= date("Y/m/d H:i:s");
        $safeFilename .= "|*|";
        $this->_renameFile = $safeFilename;
    }

    /**
     * Getter 
     * Chemin absolue pour uploader la photo ou vidéo
     *
     * @return string
     */
    public function getFolder(): string 
    {
        return $this->_folder;
    }

    /**
     * Setter
     * Largeur max photo a uploader
     *
     * @param integer $maxWidth largeur max
     * 
     * @return void
     */
    public function setMaxWidth(int $maxWidth) 
    {
        $this->_maxWidth = $maxWidth;
    }

    /**
     * Getter
     * Largeur max photo a uploader
     *
     * @return integer
     */
    public function getMaxWidth(): int 
    {
        return $this->_maxWidth;
    }

    /**
     * Setter
     * Hauteur max photo a uploader
     *
     * @param integer $maxHeight hauteur max
     * 
     * @return void
     */
    public function setMaxHeight(int $maxHeight) 
    {
        $this->_maxHeight = $maxHeight;
    }

    /**
     * Getter
     * Hauteur max photo a uploader
     *
     * @return integer
     */
    public function getMaxHeight(): int 
    {
        return $this->_maxHeight;
    }


    /**
     * Tourne la photo uploader 
     *
     * @param string $source    link file
     * @param string $extension exetnsion
     * 
     * @return void
     */
    private function _rotate(string $source, string $extension)
    {
        switch($extension){
        case 'jpg':
        case 'jpeg':
            $src = imagecreatefromjpeg($source);
            break;
        case 'png':
            $src = imagecreatefrompng($source);
            break;
        }

        $exif = exif_read_data($source);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
            case 8:
                $rotation = imagerotate($src, 90, 0);
                break;
            case 3:
                $rotation = imagerotate($src, 180, 0);
                break;
            case 6:
                $rotation = imagerotate($src, -90, 0);
                break;
            }
        }

        if (isset($rotation)) {
            switch($extension){
            case 'jpg':
            case 'jpeg':
                imagejpeg($rotation, $source);
                break;
            case 'png':
                imagepng($rotation, $source);
                break;
            }
            imagedestroy($rotation);
        }

        imagedestroy($src);
    }

    /**
     * Redimentionne une photo uploader
     *
     * @param string $source    link file
     * @param string $extension exetnsion
     * 
     * @return void
     */
    private function _resize(string $source, string $extension)
    {
        // Définition de la largeur et de la hauteur maximale
        $newWidth = $this->_maxWidth;
        $newHeight = $this->_maxHeight;
        
        // récupération des dimension de l'image source
        list($widthOrig, $heightOrig) = getimagesize($source);
        
        // Calcul des nouvelles dimensions
        $ratio_orig = $widthOrig/$heightOrig;
        if ($newWidth/$newHeight > $ratio_orig) {
            $newWidth = $newHeight*$ratio_orig; // mode portait
        } else {
            $newHeight = $newWidth/$ratio_orig; // mode paysage
        }

        // création d'une image vide
        $imDestination = imagecreatetruecolor($newWidth, $newHeight);

        // création de l'image à partir de la source
        switch($extension){
        case 'jpg':
        case 'jpeg':
            $imSource = imagecreatefromjpeg($source);
            // copie de l'image avec redimensionnement
            if (imagecopyresampled(
                $imDestination, $imSource, 0, 0, 0, 0, 
                $newWidth, $newHeight, $widthOrig, $heightOrig
            )
            ) {
                imagejpeg($imDestination, $source, 100);
            }
            break;
        case 'png':
            $imSource = imagecreatefrompng($source);
            // copie de l'image avec redimensionnement
            if (imagecopyresampled(
                $imDestination, $imSource, 0, 0, 0, 0, 
                $newWidth, $newHeight, $widthOrig, $heightOrig
            )
            ) {
                imagealphablending($imDestination, false);  
                imagesavealpha($imDestination, true);
                imagepng($imDestination, $source, 9);
            }
            break;
        }

        imagedestroy($imDestination);
        imagedestroy($imSource);
    }


    /**
     * Upload
     *
     * @param array $picture tableau $_FILES
     * 
     * @return array
     */
    public function upload($picture): array
    {
        if (empty($picture)) {
            $return["type"] = 'error';
            $return["msg"] = $this->_translator->trans('ERROR-UPLOAD');
            return $return;
        } else {
            $image_data = getimagesize($picture->getRealPath());

            if ($picture->getError() != 0) {
                $return["type"] = 'error';
                $return["msg"] = $this->_translator->trans('ERROR-UPLOAD');
                return $return;
            } else if (!in_array($picture->guessExtension(), $this->_extensions) 
                && !in_array($picture->getMimeType(), $this->_mimes)
            ) {
                $return["type"] = 'error';
                $return["msg"] = $this->_translator->trans(
                    'ERROR-UPLOAD-FORMAT',
                    array('%format%', implode(",", $this->_extensions)),
                    'messages',
                    $this->_langue
                );
                return $return;
            } else if ($this->_type === 'photos' 
                && $image_data[0] < $this->_maxWidth 
                && $image_data[0] >= $image_data[1] 
                || $image_data[1] < $this->_maxHeight 
                && $image_data[1] >=  $image_data[0]
            ) {
                $return["type"] = 'warning';
                $return["msg"] = $this->_translator->trans('SMALL-AVATAR');
                return $return;
            } else {
                $newFilename = md5($this->_renameFile);
                $newFilename .= '.'.$picture->guessExtension();
                $extension = $picture->guessExtension();
                try {
                    $picture->move(
                        $this->_folder,
                        $newFilename
                    );
                    if ($this->_type === 'photos') {
                        //chmod($this->_folder.'/'.$newFilename, 0777);
                        $this->_rotate($this->_folder.'/'.$newFilename, $extension);
                        $this->_resize($this->_folder.'/'.$newFilename, $extension);
                        $key_trans = 'AVATAR-SAVE';
                    }
                    if ($this->_type === 'videos') {
                        $key_trans = 'VIDEO-SAVE';
                    }
                    $return["type"] = 'success';
                    $return["msg"] = $this->_translator->trans(
                        $key_trans,
                        array(),
                        'messages',
                        $this->_langue
                    );
                    return $return;
                } catch (FileException $e) {
                    $return["type"] = 'error';
                    $return["msg"] = $e;
                }
            }
        }

        return $return;
    }
}
