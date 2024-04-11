<?php

namespace App\FastAdminPanel\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;

class FieldTypeRule implements Rule
{
    public $fieldType;

    public $isRequired;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($fieldType, $isRequired)
    {
        $this->fieldType = $fieldType;
        $this->isRequired = $isRequired;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (in_array($this->fieldType, ['enum', 'password', 'text', 'email', 'color', 'textarea', 'ckeditor'])) {

            return is_string($value);

        } else if(in_array($this->fieldType, ['photo'])) {

            return in_array($value->getClientMimeType(), config('lfm.folder_categories.image.valid_mime'));

        } else if(in_array($this->fieldType, ['file'])) {

            return in_array($value->getClientMimeType(), config('lfm.folder_categories.file.valid_mime'));

        } else if (in_array($this->fieldType, ['number', 'checkbox'])) {

            return is_numeric($value);
            
        } else if ($this->fieldType == 'date') {

            return DateTime::createFromFormat('Y-m-d', $value) !== false;
            
        } else if ($this->fieldType == 'datetime') {

            return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;
            
        } else if (in_array($this->fieldType, ['translater', 'gallery', 'repeat'])) {

            return is_string($value);
            
        } else if ($this->fieldType == 'money') {

            return is_numeric($value);
            
        } else if ($this->fieldType == 'relationship') {

            return $this->isRequired == 'required' ? is_numeric($value) && $value > 0 : is_numeric($value);
        }

        return false;
    }

    public function messageField()
    {
        if (in_array($this->fieldType, ['enum', 'password', 'text', 'email', 'textarea', 'color', 'ckeditor'])) {
    
            return 'string';

        }  elseif (in_array($this->fieldType, ['file', 'photo', 'gallery'])) {

            return 'correct file';

        } else if (in_array($this->fieldType, ['number', 'checkbox'])) {

            return 'integer';
            
        } else if ($this->fieldType == 'date') {

            return 'in correct date format: Y-m-d';
            
        } else if ($this->fieldType == 'datetime') {

            return 'in correct datetime format: Y-m-d H:i:s';
            
        } else if (in_array($this->fieldType, ['translater', 'repeat'])) {

            return 'string';
            
        } else if ($this->fieldType == 'money') {

            return 'float';
            
        } else if ($this->fieldType == 'relationship') {

            return 'integer';
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be '.$this->messageField();
    }
}
