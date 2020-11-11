# form-generator [![Build Status](https://travis-ci.com/moon250/formgenerator.svg?branch=master)](https://travis-ci.com/moon250/formgenerator)

FormGenerator is a class who generate form simply

# Table of contents
1. [Basic usage](#Basic-Usage)
2. [Types](#Types)
3. [Config](#Config)

## Basic usage
Start by instancing the FormGenerator class.
```php
// require the autoload (when use composer)
require_once 'vendor/autoload.php';
$form = new \FormGenerator\FormGenerator();
```

Next you can use this object for add some fields with add method. This method took 2 parameters, one is the name and
the second parameter, the type, is optionnaly. Default type is text.

```php
$form = new \FormGenerator\FormGenerator();
// This method add a field named "username" with default type (text)
$form->add('username');
// Add method is fluent
$form->add('username')->add('name');
```
For generate the form, use the "generate" method
```php
$form = new \FormGenerator\FormGenerator();

// Generate method will return only form fields (input, select, ...)
$html = $form->add('username')->generate();

// <input type="text" id="field-username" name="username" value="">
echo $html;
```

## Types

By default, the type is "text". You can change this by passed another parameter in the "add" method.

```php
$form = new \FormGenerator\FormGenerator();

// Will generate an input with "email" type.
// <input type="email" id="field-user-email" name="user-email" value="">
$form->add('user-email', 'email')->generate();
```

If the name of your field ends with "_at", the type of this field will be "date".

```php
$form = new \FormGenerator\FormGenerator();

// The input is generated with a date type
// <input type="date" id="field-created_at" name="created_at" value="">
$form->add('created_at')->generate();
// <input type="date" id="field-updated_at" name="updated_at" value="">
$form->add('updated_at')->generate();
```

If the name specified is a valid type and no type is specified in parameters, the name will be used in type.

```php
$form = new \FormGenerator\FormGenerator();

// <input type="email" id="field-email" name="email" value=""> 
$form->add('email')->generate();
```

## Config
Form-generator is fully configurable. You can for example disable the type detection with name.

```php
$form = new \FormGenerator\FormGenerator();

// <input type="text" id="field-email" name="email" value="">
$form->add('email')->generate();
```
 