php artisan schedule:run
or: 
while true; do php artisan schedule:run; sleep 60; done
This will run every minute without your interference. You exit using: Ctrl+C
On a production server, you will need to register this command in the crontab. Crontab is a file that contains a list of scripts that will run periodically. Open using:
sudo crontab -e
Go the end of the file and include this line:
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
