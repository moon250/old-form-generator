# FormGenerator [![Build Status](https://travis-ci.com/moon250/form-generator.svg?branch=master)](https://travis-ci.com/moon250/formgenerator)

FormGenerator is a class that generates forms in a very simple way.

# Table of contents
- [Basic usage](#Basic-Usage)
- [Types](#Types)
- [Config](#Config)
    - [Config Rules](#Config-Rules)
    - [EMPTY_GENERATED_FIELD](#EMPTY_GENERATED_FIELD)
    - [FORM_ACTION](#FORM_ACTION)
    - [FORM_CLASS](#FORM_CLASS)
    - [FORM_METHOD](#FORM_METHOD)
    - [FORM_SUBMIT_VALUE](#FORM_SUBMIT_VALUE)
    - [FULL_HTML_STRUCTURE](#FULL_HTML_STRUCTURE)
    - [TYPE_DETECTION](#TYPE_DETECTION)
    

## Basic usage
Start by instancing the FormGenerator class.
```php
// require the autoloader (when use composer)
require_once 'vendor/autoload.php';
$form = new \FormGenerator\FormGenerator();
```

Next, you can use this object to add some fields with the "add" method. This method took 2 parameters, one is the name, and
the second parameter is an optional type. The default type is text.

```php
$form = new \FormGenerator\FormGenerator();
// This method add a field named "username" with default type (text)
$form->add('username');
// Add method is fluent
$form->add('username')->add('name');
```
To generate the form, use the "generate" method
```php
$form = new \FormGenerator\FormGenerator();

// Generate method will return only form fields (input, select, ...)
$html = $form->add('username')->generate();

// <input type="text" id="field-username" name="username" value="">
echo $html;
```

## Types

By default, the type is "text". You can change this bypassed another parameter in the "add" method.

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

If the name specified is a valid type and no type was specified in parameters, the name will be used in type.

```php
$form = new \FormGenerator\FormGenerator();

// <input type="email" id="field-email" name="email" value=""> 
$form->add('email')->generate();
```

## Config
Form-generator is fully configurable. You can for example disable the type detection with the name.
```php
$config = new \FormGenerator\FormConfig();
$config->set('TYPE_DETECTION', false);
$form = new \FormGenerator\FormGenerator($config);

// <input type="text" id="field-email" name="email" value="">
$form->add('email')->generate();
```
You can use "get" method to see the value of a key
```php
$config = new \FormGenerator\FormConfig();
$config->get('TYPE_DETECTION'); // true
```

Key names are case-insensitive.

```php
$config = new \FormGenerator\FormConfig();
$config->set('type_detection', false);

// Echo "true"
echo $config->get('TYPE_DETECTION');
```

### Config Rules

All the config rules can be changed are listed here :

| Rule Name | Default value | Values can be attributed |
|---|---|---|
| EMPTY_GENERATED_FIELD | true | true / false |
| FORM_CLASS | null | A class name |
| FORM_METHOD | POST | GET / POST (for now) |
| FULL_HTML_STRUCTURE | false | true / false |
| TYPE_DETECTION | true | true / false |

### EMPTY\_GENERATED\_FIELD

This config rule will remove in-memory field when the "generate" method is call.
```php
$config = new \FormGenerator\FormConfig([
    'EMPTY_GENERATED_FIELD' => true // default is true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
// <input type="text" id="field-username" name="username" value="">
$form->generate();

$form->generate(); // null
```

### FORM\_ACTION
   
With this rule, you can define the action of the ``<form>``.
Default value is "null".

> Note : This rule has no effect if the "FULL_HTML_STRUCTURE" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'FULL_HTML_STRUCTURE' => true,
    'FORM_ACTION' => '/home'
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="/home" method="POST">...
```

### FORM\_CLASS
   
With this rule, you can define the class of the ``<form>``.
Default value is "null".

> Note : This rule has no effect if the "FULL_HTML_STRUCTURE" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'FORM_CLASS' => 'super-class',
    'FULL_HTML_STRUCTURE' => true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="POST" class="super-class">...
```

### FORM\_METHOD

Set the method of the form. 
Default value is "true".

> Note : This rule has no effect if the "FULL_HTML_STRUCTURE" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'FULL_HTML_STRUCTURE' => true,
    'FORM_METHOD' => 'GET'
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="GET">...
```

### FORM_SUBMIT_VALUE
Set the method of the form. 
Default value is "true".

> Note : This rule has no effect if the "FULL_HTML_STRUCTURE" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'FULL_HTML_STRUCTURE' => true,
    'FORM_METHOD' => 'GET'
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="GET">...
```
### FULL\_HTML\_STRUCTURE

When this rule is activate, the "generate" method will return entire html form structure.

```php
$config = new \FormGenerator\FormConfig([
    'FULL_HTML_STRUCTURE' => true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="POST">...</form>
```

### TYPE\_DETECTION

With this rule, if the name is a correct form type, it will be used for the type

```php
$config = new \FormGenerator\FormConfig([
    'TYPE_DETECTION' => true // default is true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('password');
// <input type="password" id="field-password" name="password" value="">
$form->generate();
```