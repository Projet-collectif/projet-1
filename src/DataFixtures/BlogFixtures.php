<?php

/**
 * PHP version 7
 *
 * @category App\DataFixtures
 * @package  BlogFixtures.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

namespace App\DataFixtures;

/**
 * PHP version 7
 *
 * @category App\DataFixtures
 * @package  BlogFixtures.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */

use App\Entity\Blog;
use App\Repository\CompteRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * PHP version 7
 *
 * @category App\DataFixtures
 * @package  BlogFixtures.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/Projet-collectif/projet-1
 */
class BlogFixtures extends Fixture
{
    /**
     * Variable $this->_compte
     *
     * @var CompteRepository
     */
    private $_compte;
    
    /**
     * Variable $this->_categories
     *
     * @var CategoriesRepository
     */
    private $_categories;

    /**
     * Void __construct()
     *
     * @param CompteRepository     $compte     comment
     * @param CategoriesRepository $categories comment
     */
    public function __construct(
        CompteRepository $compte, 
        CategoriesRepository $categories
    ) {
        $this->_compte = $compte;
        $this->_categories = $categories;
    }

    /**
     * Undocumented function
     *
     * @param ObjectManager $manager comment
     * 
     * @return void
     */
    public function load(ObjectManager $manager) 
    {
        $compte = $this->_compte->find(1);
        $categories = $this->_categories->find(1);

        $content  = 'Dum apud Persas, ut supra narravimus, ';
        $content .= 'perfidia regis motus agitat insperatos, ';
        $content .= 'et in eois tractibus bella rediviva consurgunt, ';
        $content .= 'anno sexto decimo et eo diutius post Nepotiani exitium, ';
        $content .= 'saeviens per urbem aeternam urebat cuncta Bellona, ';
        $content .= 'ex primordiis minimis ad clades excita luctuosas, ';
        $content .= 'quas obliterasset utinam iuge silentium! ne forte paria ';
        $content .= 'quandoque temptentur, plus exemplis generalibus ';
        $content .= 'nocitura quam delictis.<br>';
        
        $content .= 'Inter has ruinarum varietates a Nisibi quam tuebatur ';
        $content .= 'accitus Vrsicinus, cui nos obsecuturos iunxerat ';
        $content .= 'imperiale praeceptum, dispicere litis exitialis certamina ';
        $content .= 'cogebatur abnuens et reclamans, adulatorum ';
        $content .= 'oblatrantibus turmis, ';
        $content .= 'bellicosus sane milesque semper et militum ductor sed ';
        $content .= 'forensibus iurgiis longe discretus, qui metu sui discriminis ';
        $content .= 'anxius cum accusatores quaesitoresque subditivos sibi ';
        $content .= 'consociatos ex isdem foveis cerneret emergentes, quae ';
        $content .= 'clam palamve agitabantur, occultis Constantium litteris ';
        $content .= 'edocebat inplorans subsidia, quorum metu tumor notissimus ';
        $content .= 'Caesaris exhalaret.<br>';

        $content .= 'Pandente itaque viam fatorum sorte tristissima, ';
        $content .= 'qua praestitutum erat eum vita et imperio spoliari, ';
        $content .= 'itineribus interiectis permutatione iumentorum emensis venit ';
        $content .= 'Petobionem oppidum Noricorum, ubi reseratae sunt insidiarum ';
        $content .= 'latebrae omnes, et Barbatio repente apparuit comes, ';
        $content .= 'qui sub eo domesticis praefuit, cum Apodemio ';
        $content .= 'agente in rebus milites ducens, ';
        $content .= 'quos beneficiis suis oppigneratos elegerat imperator ';
        $content .= 'certus nec praemiis nec miseratione ulla posse deflecti.';
        
        for ($i = 1; $i <= 350; $i++) {
            $u = rand(100, 999);
            $dateNow = date('Y-m-d H:i:s');
            $dateNow = \DateTime::createFromFormat('Y-m-d H:i:s', $dateNow);
            $blog = new Blog();
            $blog->setCompte($compte);
            $blog->setTitle('Why Asteroids Taste Like Bacon '.$u);
            $blog->setSlug('why-asteroids-taste-like-bacon-'.$u);
            $blog->setContent($content);
            $blog->setCreated($dateNow);
            $blog->setPublish(true);
            $blog->setMetadesc('Why Asteroids Taste Like Bacon '.$u);
            $blog->setMetakeys('blog,fixtures,asteroid numero '.$u.',bacon '.$i);
            $blog->setHits(rand(10, 999));
            //$blog->setImage(null);
            $blog->setCategory($categories);
            $blog->setLanguage('fr');
            $manager->persist($blog);
        }

        $manager->flush();
    }
}