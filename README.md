# High-Throughput-Computing-as-a-Service (HTCaaS)

High-Throughput Computing (HTC) consists of running many loosely-coupled tasks that are independent (there is no communication needed between them) but requires a large amount of computing power during relatively a long period of time. Middleware systems such as Condor or BOINC have successfully achieved a tremendous computing power by harnessing a large number of computing resources. However, as umber of jobs and the complexity of scientific applications increase, it becomes a challenge for the traditional middleware systems employing typically a single type of resources (e.g., clusters of workstations, desktop machines over Internet) to solve the given scientific problem within a reasonable amount of time. 

Therefore, to effectively support complex and demanding scientific applications, it is inevitable to harness as many computing resources as possible including Supercomputers, Grids, and even Cloud. However, it is challenging for researchers to effectively utilize available resources that are under control by independent resource providers as the number of jobs (that should be submitted at once) increase dramatically (as in parameter sweeps or N-body calculations).

Please visit the [HTCaaS Wiki Homepage](http://htcaas.kisti.re.kr) deployed on AWS EC2. 
 
## How to set up the HTCaaS Wiki Homepage on an Apache web server running PHP 5.6+MySQL on AWS EC2

We assume that you have created a Ubuntu 20.04 instance on AWS EC2 with your AWS account. Following is a list of informative sites that you may want to look at to create a Ubuntu 20.04 instance.  
- [How to Create a Ubuntu 20.04 Server on AWS EC2](https://medium.com/nerd-for-tech/how-to-create-a-ubuntu-20-04-server-on-aws-ec2-elastic-cloud-computing-5b423b5bf635)
- [Amazon EC2 Setup with Ubuntu and XAMPP Installation](https://medium.com/@RahulShukla754/amazon-ec2-setup-with-ubuntu-and-xampp-installation-37c3c0eeb51d)
- [Tutorial: Get started with Amazon EC2 Linux instances](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/EC2_GetStarted.html)
- [Troubleshoot Permission denied (Publickey)](https://repost.aws/knowledge-center/ec2-linux-fix-permission-denied-errors)
- [윈도우 ssh 연결 에러](https://rainbound.tistory.com/entry/%EC%9C%88%EB%8F%84%EC%9A%B0-ssh-%EC%97%B0%EA%B2%B0-%EC%97%90%EB%9F%ACpermissions-too-open%EB%93%B1)

1. Log in on the Ubuntu instance using either ssh client from your terminal or EC2 instance Connect. Now you are on your EC2 instance. 
```
ubuntu@ip-172-31-32-76:~$ whoami
ubuntu

ubuntu@ip-172-31-32-76:~$ pwd
/home/ubuntu

ubuntu@ip-172-31-32-76:~$ cat /etc/*release*
DISTRIB_ID=Ubuntu
DISTRIB_RELEASE=20.04
DISTRIB_CODENAME=focal
DISTRIB_DESCRIPTION="Ubuntu 20.04.6 LTS"
NAME="Ubuntu"
VERSION="20.04.6 LTS (Focal Fossa)"
ID=ubuntu
ID_LIKE=debian
PRETTY_NAME="Ubuntu 20.04.6 LTS"
VERSION_ID="20.04"
HOME_URL="https://www.ubuntu.com/"
SUPPORT_URL="https://help.ubuntu.com/"
BUG_REPORT_URL="https://bugs.launchpad.net/ubuntu/"
PRIVACY_POLICY_URL="https://www.ubuntu.com/legal/terms-and-policies/privacy-policy"
VERSION_CODENAME=focal
UBUNTU_CODENAME=focal
```
2. Download the HTCaaS Project from this github repository.
```
ubuntu@ip-172-31-32-76:~$ git clone https://github.com/hwang2006/high-throughput-computing-as-a-service.git
Cloning into 'high-throughput-computing-as-a-service'...
remote: Enumerating objects: 8531, done.
remote: Counting objects: 100% (36/36), done.
remote: Compressing objects: 100% (34/34), done.
remote: Total 8531 (delta 9), reused 6 (delta 0), pack-reused 8495
Receiving objects: 100% (8531/8531), 164.07 MiB | 21.68 MiB/s, done.
Resolving deltas: 100% (1238/1238), done.
Updating files: 100% (8720/8720), done.

ubuntu@ip-172-31-32-76:~$ ls -al
total 32
drwxr-xr-x 5 ubuntu ubuntu 4096 Oct  5 12:27 .
drwxr-xr-x 3 root   root   4096 Oct  5 11:58 ..
-rw-r--r-- 1 ubuntu ubuntu  220 Feb 25  2020 .bash_logout
-rw-r--r-- 1 ubuntu ubuntu 3771 Feb 25  2020 .bashrc
drwx------ 2 ubuntu ubuntu 4096 Oct  5 11:59 .cache
-rw-r--r-- 1 ubuntu ubuntu  807 Feb 25  2020 .profile
drwx------ 2 ubuntu ubuntu 4096 Oct  5 11:58 .ssh
drwxrwxr-x 5 ubuntu ubuntu 4096 Oct  5 12:27 high-throughput-computing-as-a-service

ubuntu@ip-172-31-32-76:~$ ls -al high-throughput-computing-as-a-service/
total 22004
drwxrwxr-x  5 ubuntu ubuntu     4096 Oct  5 12:27 .
drwxr-xr-x  5 ubuntu ubuntu     4096 Oct  5 12:27 ..
drwxrwxr-x  8 ubuntu ubuntu     4096 Oct  5 12:27 .git
-rw-rw-r--  1 ubuntu ubuntu     2658 Oct  5 12:27 README.md
drwxrwxr-x  6 ubuntu ubuntu     4096 Oct  5 12:27 htc
drwxrwxr-x 13 ubuntu ubuntu     4096 Oct  5 12:27 htcwiki
-rw-rw-r--  1 ubuntu ubuntu 22505184 Oct  5 12:27 htcwikidb_2023-09-06.sql.gz
```
3. Download XAMPP for 64 bit and run the installer. [XAMPP](https://www.apachefriends.org) is an easy to install Apache distribution containing MariaDB, PHP, and Perl.
```
ubuntu@ip-172-31-32-76:~$ wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/5.6.40/xampp-linux-x64-5.6.40-1-installer.run

ubuntu@ip-172-31-32-76:~$ ls
high-throughput-computing-as-a-service  xampp-linux-x64-5.6.40-1-installer.run

ubuntu@ip-172-31-32-76:~$ chmod +x xampp-linux-x64-5.6.40-1-installer.run

ubuntu@ip-172-31-32-76:~$ sudo ./xampp-linux-x64-5.6.40-1-installer.run
----------------------------------------------------------------------------
Welcome to the XAMPP Setup Wizard.

----------------------------------------------------------------------------
Select the components you want to install; clear the components you do not want
to install. Click Next when you are ready to continue.

XAMPP Core Files : Y (Cannot be edited)

XAMPP Developer Files [Y/n] :y  <=== type y

Is the selection above correct? [Y/n]: y <=== type y

----------------------------------------------------------------------------
Installation Directory

XAMPP will be installed to /opt/lampp
Press [Enter] to continue:  <=== press enter

----------------------------------------------------------------------------
Setup is now ready to begin installing XAMPP on your computer.

Do you want to continue? [Y/n]: y

----------------------------------------------------------------------------
Please wait while Setup installs XAMPP on your computer.

 Installing
 0% ______________ 50% ______________ 100%
 #########################################

----------------------------------------------------------------------------
Setup has finished installing XAMPP on your computer.

ubuntu@ip-172-31-32-76:~$ ls /opt/lampp/
COPYING.thirdparty  cgi-bin       icons            lib                    manual      proftpd         uninstall.dat
README-wsrep        ctlscript.sh  img              libexec                modules     properties.ini  var
RELEASENOTES        docs          include          licenses               mysql       sbin            xampp
apache2             error         info             logs                   pear        share
bin                 etc           killprocess.bat  man                    php         temp
build               htdocs        lampp            manager-linux-x64.run  phpmyadmin  uninstall
```
4. Run the XAMPP (lampp) server 
```
ubuntu@ip-172-31-32-76:~$ sudo /opt/lampp/lampp start
Starting XAMPP for Linux 5.6.40-1...
XAMPP: Starting Apache...already running.
XAMPP: Starting MySQL.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
ok.
XAMPP: Starting ProFTPD.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
ok.

ubuntu@ip-172-31-32-76:~$ sudo apt-get update

ubuntu@ip-172-31-32-76:~$ sudo apt-get install net-tools

ubuntu@ip-172-31-32-76:~$ sudo /opt/lampp/lampp restart
Restarting XAMPP for Linux 5.6.40-1...
XAMPP: Stopping Apache...ok.
XAMPP: Stopping MySQL...ok.
XAMPP: Stopping ProFTPD...ok.
XAMPP: Starting Apache...ok.
XAMPP: Starting MySQL...ok.
XAMPP: Starting ProFTPD...ok.
```
5. Open your browser and access http://your-ubuntu-instance-public-ip-address. You will have the XAMPP dashboard page. Click the phyMyAdmin tab on the right top of the dashboard page or access http://your-ubuntu-instance-public-ip-address/phpmyadmin. You will find the following Access forbidden screen.

<p align="center">
  <img src="https://github.com/hwang2006/high-throughput-computing-as-a-service/assets/84169368/0b2b5026-8592-4415-b989-fc1877cc8dfb" height="300">
</p>

6. Edit the XAMPP configuration file. Replace the "local" with "all granted" in the /opt/lampp/etc/extra/httpd-xampp.conf file and restart it.
```
ubuntu@ip-172-31-32-76:~$ cat /opt/lampp/etc/extra/httpd-xampp.conf
...
LoadModule perl_module        modules/mod_perl.so

Alias /phpmyadmin "/opt/lampp/phpmyadmin"

# since XAMPP 1.4.3
<Directory "/opt/lampp/phpmyadmin">
    AllowOverride AuthConfig Limit
    Require all granted   
    ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
</Directory>
...

ubuntu@ip-172-31-32-76:~$ sudo /opt/lampp/lampp restart
Restarting XAMPP for Linux 5.6.40-1...
XAMPP: Stopping Apache...ok.
XAMPP: Stopping MySQL...ok.
XAMPP: Stopping ProFTPD...ok.
XAMPP: Starting Apache...ok.
XAMPP: Starting MySQL...ok.
XAMPP: Starting ProFTPD...ok.
```
7. Configure some XAMPP security settings.
```
ubuntu@ip-172-31-32-76:~$  sudo /opt/lampp/xampp security
XAMPP:  Quick security check...
XAMPP:  MySQL is accessable via network. 
XAMPP: Normaly that's not recommended. Do you want me to turn it off? [yes]    <=== type enter
XAMPP:  Turned off.
XAMPP: Stopping MySQL...ok.
XAMPP: Starting MySQL...ok.
XAMPP:  The MySQL/phpMyAdmin user pma has no password set!!! 
XAMPP: Do you want to set a password? [yes] yes   <=== type yes
XAMPP: Password: *********
XAMPP: Password (again): **********
XAMPP:  MySQL has no root passwort set!!! 
XAMPP: Do you want to set a password? [yes] yes   <=== type yes 
XAMPP:  Write the password somewhere down to make sure you won't forget it!!! 
XAMPP: Password: **********
XAMPP: Password (again): **********
XAMPP:  Setting new MySQL root password.
XAMPP:  Change phpMyAdmin's authentication method.
XAMPP:  The FTP password for user 'daemon' is still set to 'xampp'. 
XAMPP: Do you want to change the password? [yes] no   <=== type no
XAMPP:  Done.
```
8. Access the phpmyadmin page (http://your-ubuntu-instance-public-ip-address/phpmyadmin) using the MySQL root account.
<p align="center">
  <img src="https://github.com/hwang2006/high-throughput-computing-as-a-service/assets/84169368/6c0fa833-ab1c-4381-9251-3a1caece370a" height="300">
</p>
9. Create the htcaas wiki database (e.g., htcwikidb) with utf8_general_ci.
<br/><br/>
<p align="center">
  <img src="https://github.com/hwang2006/high-throughput-computing-as-a-service/assets/84169368/90b5ca5b-4032-45a5-ae42-5ecfa368f9cb" height="200">
</p>
10. Create the htcwikidb tables by importing the HTCaaS Wiki sql file (i.e., htcwikidb_2023-09-06.sql.gz)
<br/><br/>
<p align="center">
  <img src="https://github.com/hwang2006/high-throughput-computing-as-a-service/assets/84169368/def481ee-bc80-418b-b813-395f5325c9b9" height="300">
</p>

<p align="center">
  <img src="https://github.com/hwang2006/high-throughput-computing-as-a-service/assets/84169368/b684b86d-2f12-4a75-9136-863a4c9f3ba6" height="300">
</p>

11. Copy the htcwiki directory into the lampp server directory.
```
ubuntu@ip-172-31-32-76:~$ sudo cp -r /home/ubuntu/high-throughput-computing-as-a-service/htcwiki /opt/lampp/htdocs

ubuntu@ip-172-31-32-76:~$ ls /opt/lampp/htdocs
applications.html  bitnami.css  dashboard  favicon.ico  htcwiki  img  index.php  webalizer
```
12. Edit the LocalSettings.php file in the /opt/lampp/htdocs/htcwiki directory.
```
ubuntu@ip-172-31-32-76:~$ sudo vi /opt/lampp/htdocs/htcwiki/LocalSettings.php
...
## The protocol and server name to use in fully-qualified URLs
#$wgServer           = "http://htcaas.kisti.re.kr";
$wgServer           = "http://your-ubuntu-instance-public-ip-address";
...
## Database settings
$wgDBtype           = "mysql";
$wgDBserver         = "localhost";
#$wgDBname           = "mediawiki";
$wgDBname           = "htcwikidb";   <=== the htcaas_wiki database name that you have created 
$wgDBuser           = "root";
$wgDBpassword       = "**********";
...
```
13. Edit the index.php file in the /opt/lampp/htdocs. Replace the /dashboard/ with /htcwiki/.
```
ubuntu@ip-172-31-32-76:~$ cat /opt/lampp/htdocs/index.php
<?php
        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
                $uri = 'https://';
        } else {
                $uri = 'http://';
        }
        $uri .= $_SERVER['HTTP_HOST'];
        header('Location: '.$uri.'/htcwiki/');   <=== instead of header('Location: '.$uri.'/dashboard/');
        exit;
?>
Something is wrong with the XAMPP installation :-(
```
14. restart the lampp server
```
ubuntu@ip-172-31-32-76:~$ sudo /opt/lampp/lampp restart
```
15. Accecc the HTCaaS Wiki Website (http://your-ubuntu-instance-public-ip-address) that you have just deployed on AWS EC2. Congratulation!!!


