<?php

namespace JaztecBase\Model;

trait ProvidesValidator
{
    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * Validate this model
     *
     * @return boolean
     */
    public function isValid()
    {
        $data = get_object_vars($this);
        $data['this'] = $this;

        $inputFilter = $this->getInputFilter();
        $inputFilter->setData($data);

        $isValid = $inputFilter->isValid();

        foreach ($inputFilter->getValues() as $property => $value) {
            $this->{$property} = $value;
        }

        return $isValid;
    }

    /**
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (is_array($this->inputFilter)) {

            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            foreach ($this->inputFilter as $name => $config) {
                $config['name'] = $name;
                $inputFilter->add($factory->createInput($config));
            }

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
