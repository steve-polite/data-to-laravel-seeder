# Data to Laravel seeders
This utility allows you to convert CSV and JSON files to Laravel seeders.

## Usage
Create ```./files``` and ```./output``` folders in project root.  
Put the files you want to convert in ```./files``` folder.  
Run ```convert.php``` script and follow the instructions.

### Usage example
```
$ php convert.php
$ Enter the laravel version (5.7): 5.6
$
$ Create seeder for the file pippo.csv
$ Enter the seeder class name: LelloFreshSeeder
$ Enter the connection name (default) :
$ Enter the seeder table name: lello_fresh
$ ./output/LelloFreshSeeder.php file created

```


## Supported Laravel versions 
From **5.1** to **5.7** 


###### Feel free to submit corrections or improvements.
