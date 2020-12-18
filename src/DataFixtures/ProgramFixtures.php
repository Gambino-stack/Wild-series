<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\User;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
            'category' => 'categorie_4',
            'poster' => 'https://www.emp-online.fr/dw/image/v2/BBQV_PRD/on/demandware.static/-/Sites-master-emp/default/dweeebcf6c/images/2/6/6/7/266700-emp.jpg?sw=1000&sh=800&sm=fit&sfrm=png'
        ],
        'The Haunting Of Hill House' => [
            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
            'category' => 'categorie_4',
            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/818egkHyB1L._AC_SY741_.jpg'
        ],
        'American Horror Story' => [
            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',
            'category' => 'categorie_4',
            'poster' => 'https://fr.web.img4.acsta.net/pictures/19/08/13/10/05/4800587.jpg'

        ],
        'Love Death And Robots' => [
            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
            'category' => 'categorie_4',
            'poster' => 'https://www.ecranlarge.com/uploads/image/001/117/rlrri2b6rvm9i9xobtkqctaehke-251.jpg'
        ],
        'Penny Dreadful' => [
            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',
            'category' => 'categorie_4',
            'poster' => 'https://fr.web.img2.acsta.net/pictures/16/02/26/17/48/506664.jpg'

        ],
        'Fear The Walking Dead' => [
            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
            'category' => 'categorie_4',
            'poster' => 'https://fr.web.img6.acsta.net/pictures/19/07/19/09/25/2947268.jpg'

        ],
    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {

        $i = 0;
        foreach (self::PROGRAMS as $title => $data) {
            $program = new Program();
            $program->setTitle($title);
            $slug = $this->slugify->generate($title);
            $program->setSlug($slug);
            $program->setOwner($this->getReference('user'));
            $program->setSummary($data['summary']);
            $program->setPoster($data['poster']);
            $program->setCategory($this->getReference('category_0'));
            $manager->persist($program);
            $this->addReference('program_' . $i, $program);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }

}
