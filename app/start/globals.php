<?php
    ClassLoader::addDirectories(array(
    
        app_path().'/commands',
        app_path().'/controllers',
        app_path().'/models',
        app_path().'/database/seeds',
        app_path().'/Libraries/MyClass', 
        app_path().'/Libraries/MyModel', 
    
    ));
?>