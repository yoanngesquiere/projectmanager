<?php

use Behat\Behat\Context\Context;
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
    protected $bundle;

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
        $entities = $em->getRepository($this->bundle.':'.$object)->findBy(array($field => $value));
        foreach ($entities as $key => $entity) {
            $em->remove($entity);
            $em->flush($entity);
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

    private function iFollowSomethingAfter($link, $element, $subelement, $value, $something)
    {
        $session = $this->getSession();
        $xpath = "//".$element."[".$subelement."//text()[contains(., '". $value ."')]]//". $something ."[contains(., '". $link ."')]";
        $result = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        );
        if (null === $result) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath %s', $xpath));
        }
        return $result;
    }

    /**
     * @When /^I follow "(?P<link>(?:[^"]|\\")*)" in "(?P<element>(?:[^"]|\\")*)" with element "(?P<subelement>(?:[^"]|\\")*)" "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function iFollowLinkAfter($link, $element, $subelement, $value)
    {
        $result = $this->iFollowSomethingAfter($link, $element, $subelement, $value, 'a');
        $result->click();
    }

    /**
     * @When /^I press "(?P<link>(?:[^"]|\\")*)" in "(?P<element>(?:[^"]|\\")*)" with element "(?P<subelement>(?:[^"]|\\")*)" "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function iPressLinkAfter($link, $element, $subelement, $value)
    {
        $result = $this->iFollowSomethingAfter($link, $element, $subelement, $value, 'button');
        $result->press();
    }
}
