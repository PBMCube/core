<?php
declare(strict_types=1);

namespace LotGD\Core\Doctrine\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Attribute;
use LotGD\Core\Exceptions\ArgumentException;

/**
 * Annotation that is used to link a static method to a model entity.
 * @package LotGD\Core\Doctrine\Annotations
 * @Annotation
 * @Target("METHOD")
 * @Attributes({
 *  @Attribute("as", type = "string")
 * })
 */
class ExtensionMethod
{
    /** @var string */
    private $methodName = "";

    /**
     * ExtensionMethod constructor.
     * @param array $attributes
     * @throws ArgumentException
     */
    public function __construct(array $attributes) {
        $this->methodName = $attributes["as"];

        if (!is_string($this->methodName)) {
            throw new ArgumentException("Property 'as' must be a string.");
        }

        if (strlen($this->methodName) == 0) {
            throw new ArgumentException("Property 'as' must not be an empty string.");
        }
    }

    /**
     * Returns the method name.
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }
}