
![UC Logo](https://flintsdesigns.co.uk/IMG/UC_Logo.png)
## Unit Commander Theme Documentation

This document aims to outline the steps required to create a custom theme for the Unit Commander App. In this repository, all the files required are provided, and all are required to create a theme. 

# Contents
 - Essential Information
 - Models
 - What the Example Files include
 - Data available in templates
 - Common Issues
 - Support
 
 
 # Essential Information
 In order to get started with your custom theme, there are a few things you need to know. Firstly, you will not be able to use these files on your local machine for testing, which will be explained shortly. Secondly, all of the files provided must be uploaded in the final ZIP file for the theme to work, otherwise you will encounter large issues. On top of this, the default theme is built on the Bootstrap 4 Framework, however, this can be removed/replaced with a framework of your choice. 
 
 The Unit Commander Application uses the Blade Template Engine (from Laravel), which means that you have access to certain backend elements in the template files, for permissions, rendering data and much more. In the example files, you will notice a directory called "layouts", which contains a file named "layout.blade.php", this is where the main skeleton of your theme will go. It contains the <head> element, navigation system, footer and any scripts you need to load. In this file, you will notice the @content() variable, which is used to render in the individual theme files (detailed later). 
  
 Now, onto the "views" directory. This is where the bulk of your theme will be stored. You'll notice a set of predefined directories and files. It is imperative that these file names and directory names ARE NOT changed, under any circumstances. Unit Commander is programmed to search for these exact locations, and removing them would create large errors. 


# Models
Unit Commander uses the models for accessing information. This means, that when you access an object in a template, you're not only accessing the data, but you also have access to a series of functions that will make life easier. A lot of these functions are what we call "Relationships" and can be used to access related information. For example, the User model has a relationship called "awards" which will return an array of award objects, and vice versa. Below, I will outline the most common models you will encounter, and list their relationships/functions


***User Model***
This is the most critical model, and includes ALL the relationships required for Unit Commander Profiles. 
*Model Data Return:*
```php
    "id" => 1
    "steam64" => "76561198122454585"
    "nickname" => "Flinty"
    "avatar" => "<full_avatar_link>"
    "profile_url" => "<profile_url>"
    "name" => "L. Flint"
    "email" => "<email>"
    "rank_id" => null
    "email_verified_at" => null //Unused, deprecated in upcoming update
    "remember_token" => "<remember_token>" //Do not ever print this
    "created_at" => "2020-07-12 12:34:14"
    "updated_at" => "2020-08-03 18:31:20"
```
*Relationships*
 - units(): Returns all Units the user is a member of
     - Array of Unit::class()
 - rank(): Returns associated rank details
     - Rank::class()
 - awards(): Returns all Awards associated with the user
     - Array of Award::class()
 - trainings(): Returns all Training Accomplishments associated with the user
     - Array of Training::class()
 - positions(): Returns all Positions associated with the user
     - Array of Position::class()
 - roles(): Returns all User Groups/Roles the user belongs to, i.e. Administrator
     - Array of Role::class()
 - events(): Returns all events the user has registered attendance for
     - Array of Event::class()
         - Includes attendance Status ID: status_id
 - custom_fields(): Returns all custom fields the user has been assigned, along with values
     - Array of UserField::class()


 # What the Example Files Include
 The example files include everything required for the Default Unit Commander theme.
 
 **assets** 
  - This directory includes folders for CSS, JS and any Images required. Any assets you wish to upload must be placed in their respective categories. In order to access these in your blade templates, use the @asset() directive, e.g. *"@asset('css/Global.css')"*
  
 **layouts** 
  - This directory contains the master layout file, as previously explained. This file will contain the main skeleton for your new theme. 
  
 **partials**
  - This is not used by Unit Commander, however you are welcome to check out the documentation at https://github.com/Flinty916/laravel-theme
  
 **views** 
  - This is where the bulk of the theme templates are stored
  - Do not, under any circumstances, change directory or file names, as this will break Unit Commander
  - In the "auth" folder, you only need to edit "login.blade.php"
  
 **widgets**
  - This is not used by Unit Commander, however you are welcome to check out the documentation at https://github.com/Flinty916/laravel-theme
  
 **theme.json**
  - This is the theme manifest file, that lets Unit Commander know what the details of this theme are. Edit this to your liking, however do not change the overall structure. 
  
 **config.php** 
  - This is not used by Unit Commander, however you are welcome to check out the documentation at https://github.com/Flinty916/laravel-theme
  
  
  # Data Available in Templates
  
 *dashboard.blade.php*
  1. $events
     - Type: Array of Objects
         - Object Sample: 
         ```php
             "id" => 1
             "name" => "Operation Treadstone"
             "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostru"
             "image" => "/IMG/Uploads/20181210194805_1.jpg"
             "date" => "2020-12-25 00:00:00"
             "time" => "19:30"
             "map" => "Stratis"
             "briefing_id" => null
             "created_at" => "2020-07-16 18:44:41"
             "updated_at" => "2020-08-11 20:25:10"
         ```
     - Contains: Upcoming Events
     - Example: 
         ```html
                             @forelse($events as $event)
                                 <div class="col-lg-6">
                                     <div class="card-table">
                                         <div class="row">
                                             <div class="col-lg-12">
                                                 <h3>{{ $event->name }}</h3>
                                             </div>
                                             <div class="col">
                                                 <p>{{ $event->description }}</p>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col">
                                                 <a href="/events/{{$event->id}}" class="btn btn-outline-primary btn-block">View
                                                     Event Details</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @empty
                                 <div class="col">
                                     <center>
                                         <p>No Events Available.</p>
                                     </center>
                                 </div>
                             @endforelse
         ```
