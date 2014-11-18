<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, KernelAwareContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    protected function unescape($value)
    {
        return str_replace('""', '"', $value);
    }
    protected function escape($value)
    {
        return str_replace('"', '""', $value);
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When /^I remove "(?P<object>(?:[^"]|\\")*)" with "(?P<field>(?:[^"]|\\")*)" "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function iRemoveObject($object, $field, $value)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $entities = $em->getRepository('ProjectManagerUserBundle:'.$object)->findBy(array($field => $value));
        foreach ($entities as $key => $entity) {
            $em->remove($entity);
            $em->flush();
        }
    }

    /**
     * @When /^I fill:$/
     */
    public function iFill(TableNode $table)
    {
        foreach ($table->getRowsHash() as $key => $value) {
            $this->fillField($this->escape($key), $this->escape($value));
        }
    }
}
