<?php

namespace Stfalcon\Bundle\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\DependentFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Stfalcon\Bundle\EventBundle\Entity\Event;
use Stfalcon\Bundle\EventBundle\Entity\PromoCode;

/**
 * LoadPromoCodeData Class
 */
class LoadPromoCodeData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Return fixture classes fixture is dependent on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'Stfalcon\Bundle\EventBundle\DataFixtures\ORM\LoadEventData'
        );
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var Event $eventZFDays, $eventPHPDay */
        $eventZFDays = $manager->merge($this->getReference('event-zfday'));
        $eventPHPDay = $manager->merge($this->getReference('event-phpday'));

        // Promo code 1
        $promoCode = new PromoCode();
        $promoCode
            ->setTitle('Promo code for ZFDays')
            ->setCode('Promo code for ZFDays')
            ->setEvent($eventZFDays);
        $manager->persist($promoCode);
        $this->addReference('promoCode-1', $promoCode);

        // Promo code 2
        $promoCode = new PromoCode();
        $promoCode
            ->setTitle('Promo code for ZFDays 5%')
            ->setCode('Promo code for ZFDays 5%')
            ->setDiscountAmount(5)
            ->setEvent($eventZFDays);
        $manager->persist($promoCode);
        $this->addReference('promoCode-2', $promoCode);

        // Promo code 3
        $promoCode = new PromoCode();
        $promoCode
            ->setTitle('Promo code for ZFDays overdue')
            ->setCode('Promo code for ZFDays overdue')
            ->setEvent($eventZFDays)
            ->setEndDate(new \DateTime('-11 Days'));
        $manager->persist($promoCode);
        $this->addReference('promoCode-3', $promoCode);

        // Promo code 4
        $promoCode = new PromoCode();
        $promoCode
            ->setTitle('Promo code for PHPDay')
            ->setCode('Promo code for PHPDay')
            ->setEvent($eventPHPDay);
        $manager->persist($promoCode);
        $this->addReference('promoCode-4', $promoCode);

        $manager->flush();
    }
}
