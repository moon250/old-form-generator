# FormGenerator 
[![Build Status](https://travis-ci.com/moon250/form-generator.svg?branch=master)](https://travis-ci.com/moon250/formgenerator)
[![Coverage Status](https://coveralls.io/repos/github/moon250/form-generator/badge.svg?branch=master)](https://coveralls.io/github/moon250/form-generator?branch=master)

FormGenerator is a class that generates forms in a very simple way.

# Table of contents
- [Installation](#Installation)
- [Basic usage](#Basic-Usage)
- [Types](#Types)
- [Options](#Options)
- [Configuration](#Configuration)
    - [Configuration Rules](#Config-Rules)
    - [empty_generated_field](#empty_generated_field)
    - [form_action](#form_action)
    - [form_class](#form_class)
    - [form_method](#form_method)
    - [form_submit](#form_submit)
    - [form_submit_value](#form_submit_value)
    - [full_html_structure](#full_html_structure)
    - [type_detection](#type_detection)
- [Examples](#Examples)
    
## Installation 
You can use composer for install this package.
```
composer require moon250/form-generator 
```

## Basic Usage
Start by instancing the FormGenerator class.
```php
// require the autoloader (when use composer)
require_once 'vendor/autoload.php';
$form = new \FormGenerator\FormGenerator();
```

Next, you can use this object to add some fields with the "add" method. This method took 2 parameters, one is the name, and
the second parameter is for define the type. This parameter is optionnaly. The default type is text.

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

// <input type="text" id="field-username" name="username" value="" required="">
echo $html;
```

## Types

By default, the type is "text". You can change this by pass another parameter in the "add" method.

```php
$form = new \FormGenerator\FormGenerator();

// Will generate an input with "email" type.
// <input type="email" id="field-user-email" name="user-email" value="" required="">
$form->add('user-email', 'email')->generate();
```

If the name of your field ends with "_at", the type of this field will be "date".

```php
$form = new \FormGenerator\FormGenerator();

// The input is generated with a date type
// <input type="date" id="field-created_at" name="created_at" value="" required="">
$form->add('created_at')->generate();
// <input type="date" id="field-updated_at" name="updated_at" value="" required="">
$form->add('updated_at')->generate();
```

If the name specified is a valid type and no type was specified in parameters, the name will be used in type.

```php
$form = new \FormGenerator\FormGenerator();

// <input type="email" id="field-email" name="email" value=""> 
$form->add('email')->generate();
```

## Options

In the third parameter of the "add" method, you can pass an array of options.

All the options are list here :

| Option name | Usage | Value |
|:-----------:|-------|-------|
| class | Define the class of the field | ``string`` A class name |
| label | Define the label for the field | ``string`` The label content |
| placeholder | Define placeholder of the field | ``string`` The placeholder |
| required | Define if the field is required | ``bool`` true / false (default to true) |
| value | You can define the value of the field here | ``string`` The value of the field |

Example :
```php
$form = new \FormGenerator\FormGenerator();

// <input type="text" id="field-username" name="username" value="" required="" class="super-class">
$form->add('username', null, [
    'class' => 'super-class'
])->generate();
```

## Configuration
Form-generator is fully configurable. You can for example disable the type detection with the name.
```php
$config = new \FormGenerator\FormConfig();
$config->set('type_detection', false);
$form = new \FormGenerator\FormGenerator($config);

// <input type="text" id="field-email" name="email" value="" required="">
$form->add('email')->generate();
```
You can use "get" method to see the value of a key
```php
$config = new \FormGenerator\FormConfig();
$config->get('type_detection'); // true
```

Key names are case-insensitive.

```php
$config = new \FormGenerator\FormConfig();
$config->set('TYPE_DETECTION', false);

// Echo "false"
echo $config->get('type_detection');
```

You can also pass an array to the FormConfig constructor for define config rules.

```php
$config = new \FormGenerator\FormConfig([
    'type_detection' => false,
    'empty_generated_fields' => false
]);

// Echo "false"
echo $config->get('type_detection');
// Echo "false"
echo $config->get('empty_generated_fields');
```

### Config Rules

All the config rules can be changed are listed here :

| Rule Name | Default value | Values can be attributed |
|:----------|:-------------:|:-------------------------|
| [empty_generated_field](#empty_generated_field) | true | ``bool`` true / false |
| [form_action](#form_action) | null | ``string`` The route / file form action |
| [form_class](#form_class) | null | ``string`` A class name |
| [form_method](#form_method) | POST | ``string`` GET / POST (for now) |
| [form_submit](#form_submit) | false | ``bool`` true / false |
| [form_submit_value](#form_submit_value) | null | ``string`` A value |
| [full_html_structure](#full_html_structure) | false | ``bool`` true / false |
| [type_detection](#type_detection) | true | ``bool`` true / false | 

### empty_generated_field

This config rule will remove in-memory field when the "generate" method is call.
Default value is "true".

```php
$config = new \FormGenerator\FormConfig([
    'empty_generated_field' => true // default is true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
// <input type="text" id="field-username" name="username" value="" required="">
$form->generate();

$form->generate(); // null
```

### form_action
   
With this rule, you can define the action of the ``<form>``.
Default value is "null".

> Note : This rule has no effect if the "full_html_structure" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'full_html_structure' => true,
    'form_action' => '/home'
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="/home" method="POST">...
```

### form_class
   
With this rule, you can define the class of the ``<form>``.
Default value is "null".

> Note : This rule has no effect if the "full_html_structure" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'form_class' => 'super-class',
    'full_html_structure' => true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="POST" class="super-class">...
```

### form_method

Set the method of the form. 
Default value is "POST".

> Note : This rule has no effect if the "full_html_structure" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'full_html_structure' => true,
    'form_method' => 'GET'
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="GET">...
```

### form_submit
Define if the form contains a "submit" input or not.
Default is "true".
> Note : This rule has no effect if the "full_html_structure" rule
is not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'full_html_structure' => true,
    'form_submit' => true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');

// <form method="POST" action="">
//     <input type="text" id="field-username" name="username" value="" required="">
//     <input type="submit">
// </form>
$form->generate();
```

### form_submit_value
Set the value of the "submit" input.
Default value is "null".

> Note : This rule has no effect if the "full_html_structure" and "form_submit" rules
are not on "true" value. 

```php
$config = new \FormGenerator\FormConfig([
    'full_html_structure' => true,
    'form_submit' => true,
    'form_submit_value' => 'Send !'
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');

// <form method="POST" action="">
//     <input type="text" id="field-username" name="username" value="" required="">
//     <input type="submit" value="Send !">
// </form>
$form->generate();
```
### full_html_structure

When this rule is activate, the "generate" method will return entire html form structure.
Default value is "false".

```php
$config = new \FormGenerator\FormConfig([
    'full_html_structure' => true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('username');
$form->generate(); // <form action="" method="POST">...</form>
```

### type_detection

With this rule, if the name is a correct form type, it will be used for the type.

```php
$config = new \FormGenerator\FormConfig([
    'type_detection' => true // default is true
]);

$form = new \FormGenerator\FormGenerator($config);
$form->add('password');
// <input type="password" id="field-password" name="password" value="" required="">
$form->generate();
```
## Examples

Making a login form using bootstrap template.

```php
require_once 'vendor/autoload.php';
    
$config = new \FormGenerator\FormConfig([
    'full_html_structure' => true,
    'form_submit_value' => 'Login',
    'form_action' => '/home'
]);

$generator = new FormGenerator\FormGenerator($config);

$form = $generator
    ->add('username', null, [
    'label' => 'Your username',
    'placeholder' => 'Username',
    'class' => 'form-control'
])
    ->add('password', null, [
    'label' => 'Your password',
    'placeholder' => 'Password',
    'class' => 'form-control'
])->generate();

// <form method="POST" action="/home">
//     <label for="field-username">Your username</label>
//     <input type="text" id="field-username" name="username" value="" placeholder="Username" required="" class="form
//-control">
//     <label for="field-password">Your password</label>
//     <input type="password" id="field-password" name="password" value="" placeholder="Password" required="" class=
//"form-control">
//     <input type="submit" value="Login">
// </form>
echo '<div class="form-group">' . $form . '</div>';
```