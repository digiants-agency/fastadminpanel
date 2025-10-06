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

        } elseif (in_array($this->fieldType, ['photo'])) {

            return in_array($value->getClientMimeType(), config('lfm.folder_categories.image.valid_mime'));

        } elseif (in_array($this->fieldType, ['file'])) {

            return in_array($value->getClientMimeType(), config('lfm.folder_categories.file.valid_mime'));

        } elseif (in_array($this->fieldType, ['number', 'checkbox'])) {

            return is_numeric($value);

        } elseif ($this->fieldType == 'date') {

            return DateTime::createFromFormat('Y-m-d', $value) !== false;

        } elseif ($this->fieldType == 'datetime') {

            return DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false;

        } elseif (in_array($this->fieldType, ['translater', 'gallery', 'repeat'])) {

            return is_string($value);

        } elseif ($this->fieldType == 'money') {

            return is_numeric($value);

        } elseif ($this->fieldType == 'relationship') {

            return $this->isRequired == 'required' ? is_numeric($value) && $value > 0 : is_numeric($value);
        }

        return false;
    }

    public function messageField()
    {
        if (in_array($this->fieldType, ['enum', 'password', 'text', 'email', 'textarea', 'color', 'ckeditor'])) {

            return 'string';

        } elseif (in_array($this->fieldType, ['file', 'photo', 'gallery'])) {

            return 'correct file';

        } elseif (in_array($this->fieldType, ['number', 'checkbox'])) {

            return 'integer';

        } elseif ($this->fieldType == 'date') {

            return 'incorrect date format: Y-m-d';

        } elseif ($this->fieldType == 'datetime') {

            return 'incorrect datetime format: Y-m-d H:i:s';

        } elseif (in_array($this->fieldType, ['translater', 'repeat'])) {

            return 'string';

        } elseif ($this->fieldType == 'money') {

            return 'float';

        } elseif ($this->fieldType == 'relationship') {

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
