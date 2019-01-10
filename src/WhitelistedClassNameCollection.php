<?php declare(strict_types=1);

namespace Quanta\Utils;

final class WhitelistedClassNameCollection implements ClassNameCollectionInterface
{
    /**
     * The original collection.
     *
     * @var \Quanta\Utils\ClassNameCollectionInterface
     */
    private $collection;

    /**
     * The whitelist patterns.
     *
     * @var string[]
     */
    private $patterns;

    /**
     * Constructor.
     *
     * @param \Quanta\Utils\ClassNameCollectionInterface    $collection
     * @param string                                        ...$patterns
     */
    public function __construct(ClassNameCollectionInterface $collection, string ...$patterns)
    {
        $this->collection = $collection;
        $this->patterns = $patterns;
    }

    /**
     * @inheritdoc
     */
    public function classes(): array
    {
        $classes = $this->collection->classes();
        $classes = array_filter($classes, [$this, 'filter']);

        return array_values($classes);
    }

    /**
     * Return whether the given class name is matching at least one pattern.
     *
     * Return true when there is not pattern.
     *
     * @param string $class
     * @return bool
     */
    private function filter(string $class): bool
    {
        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $class) === 1) {
                return true;
            }
        }

        return count($this->patterns) == 0;
    }
}
