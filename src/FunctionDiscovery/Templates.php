<?php
/**
 *  This file was generated with crodas/SimpleView (https://github.com/crodas/SimpleView)
 *  Do not edit this file.
 *
 */

namespace {


    class base_template_e0e851b5775f1a02c0a611515036926579b3771d
    {
        protected $parent;
        protected $child;
        protected $context;

        public function yield_parent($name, $args)
        {
            $method = "section_" . sha1($name);

            if (is_callable(array($this->parent, $method))) {
                $this->parent->$method(array_merge($this->context, $args));
                return true;
            }

            if ($this->parent) {
                return $this->parent->yield_parent($name, $args);
            }

            return false;
        }

        public function do_yield($name, Array $args = array())
        {
            if ($this->child) {
                // We have a children template, we are their base
                // so let's see if they have implemented by any change
                // this section
                if ($this->child->do_yield($name, $args)) {
                    // yes!
                    return true;
                }
            }

            // Do I have this section defined?
            $method = "section_" . sha1($name);
            if (is_callable(array($this, $method))) {
                // Yes!
                $this->$method(array_merge($this->context, $args));
                return true;
            }

            // No :-(
            return false;
        }

    }

    /** 
     *  Template class generated from Template.tpl
     */
    class class_e0953761ca98bd90de792c473441b2aca94c2d06 extends base_template_e0e851b5775f1a02c0a611515036926579b3771d
    {

        public function hasSection($name)
        {

            return false;
        }


        public function renderSection($name, Array $args = array(), $fail_on_missing = true)
        {
            if (!$this->hasSection($name)) {
                if ($fail_on_missing) {
                    throw new \RuntimeException("Cannot find section {$name}");
                }
                return "";
            }

        }

        public function enhanceException(Exception $e, $section = NULL)
        {
            if (!empty($e->enhanced)) {
                return;
            }

            $message = $e->getMessage() . "( IN " . 'Template.tpl';
            if ($section) {
                $message .= " | section: {$section}";
            }
            $message .= ")";

            $object   = new ReflectionObject($e);
            $property = $object->getProperty('message');
            $property->setAccessible(true);
            $property->setValue($e, $message);

            $e->enhanced = true;
        }

        public function render(Array $vars = array(), $return = false)
        {
            try {
                return $this->_render($vars, $return);
            } catch (Exception $e) {
                if ($return) ob_get_clean();
                $this->enhanceException($e);
                throw $e;
            }
        }

        public function _render(Array $vars = array(), $return = false)
        {
            $this->context = $vars;

            extract($vars);
            if ($return) {
                ob_start();
            }

            echo "<?php\n\n";
            foreach($data['files'] as $file) {

                $this->context['file'] = $file;
                echo "    if (!is_" . (is_file($file) ? 'file': 'dir') . "(";
                var_export($file);
                echo ") || " . (filemtime($file)) . " < filemtime(";
                var_export($file);
                echo ")) {\n        return array('files' => array(), 'cache' => array());\n    }\n";
            }
            echo "\nreturn ";
            var_export($data);
            echo ";\n";

            if ($return) {
                return ob_get_clean();
            }

        }
    }

}

namespace FunctionDiscovery {


    class Templates
    {
        public static function getAll()
        {
            return array (
                0 => 'template',
            );
        }

        public static function getAllSections($name, $fail = true)
        {
            switch ($name) {
            default:
                if ($fail) {
                    throw new \RuntimeException("Cannot find section {$name}");
                }

                return array();
            }
        }

        public static function exec($name, Array $context = array(), Array $global = array())
        {
            $tpl = self::get($name);
            return $tpl->render(array_merge($global, $context));
        }

        public static function get($name, Array $context = array())
        {
            static $classes = array (
                'template.tpl' => 'class_e0953761ca98bd90de792c473441b2aca94c2d06',
                'template' => 'class_e0953761ca98bd90de792c473441b2aca94c2d06',
            );
            $name = strtolower($name);
            if (empty($classes[$name])) {
                throw new \RuntimeException("Cannot find template $name");
            }

            $class = "\\" . $classes[$name];
            return new $class;
        }
    }

}
