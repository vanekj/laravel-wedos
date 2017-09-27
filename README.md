## Laravel for Wedos

Laravel preparation script for Wedos shared webhosting which edits some Laravel files in order to work properly on Wedos shared webhosting service.

Thanks to Jaroslav Klimčík for his article about [Running Laravel on Wedos shared webhosting](http://laravelblog.cz/spusteni-laravelu-na-sdilenem-hostingu-wedos/).

I am open to all suggestions about the code improvement (functionality, style, etc.) :)

## How to use

1. Make fresh Laravel installation (you have two options)

   Via Laravel Installer
   ```
   $ composer global require "laravel/installer"
   $ laravel new website
   ```
  
   Via Composer Create-Project
   ```
   $ composer create-project --prefer-dist laravel/laravel website
   ```

2. Download `wedos.php`
3. Place it in Laravels root folder (where `.env` and other files are located)
4. Upload all files to your webhosting
5. Set right permissions to folders and files (FileZilla recommended)
   - All folders - 755
   - All files - 644
   - /storage - 777 (recursively for folders)
   - /bootstrap/cache - 777
6. Go to your website and navigate to `/wedos.php`
7. Check if inputs are prefilled with values
8. Hit "Start"
9. If everything went successfully, you should see Laravels start screen

## License

[MIT](https://github.com/vanekj/laravel-wedos/blob/master/LICENSE)
