<?php namespace MonkeyHook\Test;

use MonkeyHook\Types\WPFilterTestCase;
use MonkeyHook\HookCollection;
use MonkeyHook\Hook;

final class HookCollectionTest extends WPFilterTestCase {
    public function testArrayAccessIterable() {

        global $wp_filter;

        add_action('foo', 'foo');
        add_action('bar', 'bar');
        add_action('baz', 'baz');

        $collection = new HookCollection($wp_filter);       

        $this->assertEquals('foo', $collection[0]->hook_name);
        $this->assertEquals('bar', $collection[1]->hook_name);
        $this->assertEquals('baz', $collection[2]->hook_name);

        $collection[3] = ['test'];
        $this->assertEquals(['test'], $collection[3]);

        $this->assertEquals(true, isset($collection[3]));
        $this->assertEquals(false, isset($collection[4]));
        unset($collection[3]);
        $this->assertEquals(false, isset($collection[3]));

        foreach($collection as $index => $hook) {

            /**
             * @var MonkeyHook\Hook $hook
             */

            if($index === 0)
                $this->assertEquals('foo', $hook->hook_name);
                
            if($index === 1)
                $this->assertEquals('bar', $hook->hook_name);

            if($index === 2)
                $this->assertEquals('baz', $hook->hook_name);
        }

        $collection->rewind();
        $this->assertEquals('foo', $collection->current()->hook_name);
        $collection->next();

        $this->assertEquals('bar', $collection->current()->hook_name);
    }

}