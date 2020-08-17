
![UC Logo](https://flintsdesigns.co.uk/IMG/UC_Logo.png)
## Unit Commander Theme Documentation

This document aims to outline the steps required to create a custom theme for the Unit Commander App. In this repository, all the files required are provided, and all are required to create a theme. 

# Contents
 - Essential Information
 - What the Example Files include
 - Data available in templates
 - Common Issues
 - Support
 
 
 # Essential Information
 In order to get started with your custom theme, there are a few things you need to know. Firstly, you will not be able to use these files on your local machine for testing, which will be explained shortly. Secondly, all of the files provided must be uploaded in the final ZIP file for the theme to work, otherwise you will encounter large issues. On top of this, the default theme is built on the Bootstrap 4 Framework, however, this can be removed/replaced with a framework of your choice. 
 
 The Unit Commander Application uses the Blade Template Engine (from Laravel), which means that you have access to certain backend elements in the template files, for permissions, rendering data and much more. In the example files, you will notice a directory called "layouts", which contains a file named "layout.blade.php", this is where the main skeleton of your theme will go. It contains the <head> element, navigation system, footer and any scripts you need to load. In this file, you will notice the @content() variable, which is used to render in the individual theme files (detailed later). 
  
 Now, onto the "views" directory. This is where the bulk of your theme will be stored. You'll notice a set of predefined directories and files. It is imperative that these file names and directory names ARE NOT changed, under any circumstances. Unit Commander is programmed to search for these exact locations, and removing them would create large errors. 


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
